<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateTaskList;
use App\Models\TaskList;


class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = TaskList::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'tasks-lists.edit',
						'destroy' => 'tasks-lists.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('tasks-lists.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('tasks-lists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

        $validator = BeforeValidateTaskList::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('tasks-lists.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('TaskList', $request, Auth::user()));
        $model = TaskList::create($request->all());
        event(new AfterCreate('TaskList', $request, Auth::user(), $model));

        return redirect(route('tasks-lists.index'))->with('success', trans('translation.taskList.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = TaskList::find($id);

		return view('tasks-lists.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = TaskList::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

        $validator = BeforeValidateTaskList::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('tasks-lists.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('TaskList', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('TaskList', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('tasks-lists.index'))->with('success', trans('translation.taskList.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = TaskList::find($id);
        $model->delete();

        return redirect(route('tasks-lists.index'))->with('success', trans('translation.taskList.destroy'));
    }
}
