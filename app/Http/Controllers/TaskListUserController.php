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
use App\Validators\BeforeValidateTaskListUser;
use App\Models\TaskListUser;
use App\Models\TaskList;
use App\Models\User;

class TaskListUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = TaskListUser::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('user_id', function($row){
					return $row->user->email;
				})
				->addColumn('tasks_lists_id', function($row){
					return $row->taskList->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'tasks-lists-users.edit',
						'destroy' => 'tasks-lists-users.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('tasks-lists-users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$tasksList = TaskList::all();
		$users = User::all();

		return view('tasks-lists-users.create', compact('tasksList','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'tasks_lists_id' => 'required',
		]);

        $validator = BeforeValidateTaskListUser::run($validator, $request, Auth::user());

        $check = TaskListUser::where([
            'user_id' => $request->user_id,
            'tasks_lists_id' => $request->tasks_lists_id
        ])->first();
        if (!empty($check)){
            return redirect(route('tasks-lists-users.create'))->withInput()->withErrors([
                'user_id' => "User is already added in this list."
            ]);
        }

        if ($validator->fails()) {
            return redirect(route('tasks-lists-users.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('TaskListUser', $request, Auth::user()));
        $model = TaskListUser::create($request->all());
        event(new AfterCreate('TaskListUser', $request, Auth::user(), $model));

        return redirect(route('tasks-lists-users.index'))->with('success', trans('translation.taskListUser.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$tasksList = TaskList::all();
		$users = User::all();

        $model = TaskListUser::find($id);

		return view('tasks-lists-users.edit', compact('tasksList','users', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = TaskListUser::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'tasks_lists_id' => 'required',
		]);

        $validator = BeforeValidateTaskListUser::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('tasks-lists-users.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('TaskListUser', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('TaskListUser', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('tasks-lists-users.index'))->with('success', trans('translation.taskListUser.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = TaskListUser::find($id);
        $model->delete();

        return redirect(route('tasks-lists-users.index'))->with('success', trans('translation.taskListUser.destroy'));
    }
}
