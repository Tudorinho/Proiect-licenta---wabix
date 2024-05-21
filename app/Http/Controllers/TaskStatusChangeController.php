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
use App\Validators\BeforeValidateTaskStatusChange;
use App\Models\TaskStatusChange;
use App\Models\User;
use App\Models\Task;

class TaskStatusChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = TaskStatusChange::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('task_id', function($row){
					return $row->task->title;
				})
				->addColumn('user_id', function($row){
					return !empty($row->user) ? $row->user->email : '';
				})
				->addColumn('from_status', function($row){
					return $row->from_status;
				})
				->addColumn('to_status', function($row){
					return $row->to_status;
				})
				->addColumn('created_at', function($row){
					return $row->created_at;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'tasks-statuses-changes.edit',
						'destroy' => 'tasks-statuses-changes.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('tasks-statuses-changes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$users = User::all();
		$tasks = Task::all();
		$from_statuses = ['pending','done'];
		$to_statuses = ['pending','done'];

		return view('tasks-statuses-changes.create', compact('users','tasks','from_statuses','to_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'task_id' => 'required',
			'user_id' => 'required',
			'from_status' => 'required',
			'to_status' => 'required',
		]);

        $validator = BeforeValidateTaskStatusChange::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('tasks-statuses-changes.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('TaskStatusChange', $request, Auth::user()));
        $model = TaskStatusChange::create($request->all());
        event(new AfterCreate('TaskStatusChange', $request, Auth::user(), $model));

        return redirect(route('tasks-statuses-changes.index'))->with('success', trans('translation.taskStatusChange.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$users = User::all();
		$tasks = Task::all();
		$from_statuses = ['pending','done'];
		$to_statuses = ['pending','done'];

        $model = TaskStatusChange::find($id);

		return view('tasks-statuses-changes.edit', compact('users','tasks','from_statuses','to_statuses', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = TaskStatusChange::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'task_id' => 'required',
			'user_id' => 'required',
			'from_status' => 'required',
			'to_status' => 'required',
		]);

        $validator = BeforeValidateTaskStatusChange::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('tasks-statuses-changes.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('TaskStatusChange', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('TaskStatusChange', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('tasks-statuses-changes.index'))->with('success', trans('translation.taskStatusChange.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = TaskStatusChange::find($id);
        $model->delete();

        return redirect(route('tasks-statuses-changes.index'))->with('success', trans('translation.taskStatusChange.destroy'));
    }
}
