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
use App\Validators\BeforeValidateColdCallingList;
use App\Models\ColdCallingList;
use App\Models\TaskList;

class ColdCallingListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ColdCallingList::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('tasks_lists_id', function($row){
					return $row->taskList->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'cold-calling-lists.edit',
						'destroy' => 'cold-calling-lists.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('cold-calling-lists.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$tasksLists = TaskList::all();

		return view('cold-calling-lists.create', compact('tasksLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'tasks_lists_id' => 'required',
		]);

        $validator = BeforeValidateColdCallingList::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('cold-calling-lists.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('ColdCallingList', $request, Auth::user()));
        $model = ColdCallingList::create($request->all());
        event(new AfterCreate('ColdCallingList', $request, Auth::user(), $model));

        return redirect(route('cold-calling-lists.index'))->with('success', trans('translation.coldCallingLists.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$tasksLists = TaskList::all();

        $model = ColdCallingList::find($id);

		return view('cold-calling-lists.edit', compact('tasksLists', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = ColdCallingList::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'tasks_lists_id' => 'required',
		]);

        $validator = BeforeValidateColdCallingList::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('cold-calling-lists.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('ColdCallingList', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('ColdCallingList', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('cold-calling-lists.index'))->with('success', trans('translation.coldCallingLists.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ColdCallingList::find($id);
        $model->delete();

        return redirect(route('cold-calling-lists.index'))->with('success', trans('translation.coldCallingLists.destroy'));
    }
}
