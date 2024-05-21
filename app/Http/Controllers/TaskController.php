<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyContact;
use App\Models\Currency;
use App\Models\Deal;
use App\Models\DealSource;
use App\Models\DealStatus;
use App\Models\TaskListUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateTask;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskList;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Task::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('title', function($row){
					return $row->title;
				})
				->addColumn('description', function($row){
					return $row->description;
				})
				->addColumn('status', function($row){
					return $row->status;
				})
				->addColumn('priority', function($row){
					return $row->priority;
				})
				->addColumn('due_date', function($row){
					return $row->due_date;
				})
				->addColumn('user_id', function($row){
					return $row->user->email;
				})
				->addColumn('tasks_lists_id', function($row){
					return $row->taskList->name;
				})
                ->addColumn('estimate', function($row){
                    return floatval($row->estimate);
                })
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'tasks.edit',
						'destroy' => 'tasks.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('tasks.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$statuses = ['pending','done'];
		$priorities = ['low','medium','high'];
		$users = User::all();
		$tasksLists = TaskList::all();

		return view('tasks.create', compact('statuses','priorities','users','tasksLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required',
			'status' => 'required',
			'priority' => 'required',
			'due_date' => 'required',
			'user_id' => 'required',
			'tasks_lists_id' => 'required',
            'estimate' => 'numeric'
		]);

        $validator = BeforeValidateTask::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('tasks.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Task', $request, Auth::user()));
        $model = Task::create($request->all());
        event(new AfterCreate('Task', $request, Auth::user(), $model));

        return redirect(route('tasks.index'))->with('success', trans('translation.task.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$statuses = ['pending','done'];
		$priorities = ['low','medium','high'];
		$users = User::all();
		$tasksLists = TaskList::all();

        $model = Task::find($id);

		return view('tasks.edit', compact('statuses','priorities','users','tasksLists', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Task::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required',
			'status' => 'required',
			'priority' => 'required',
			'due_date' => 'required',
			'user_id' => 'required',
			'tasks_lists_id' => 'required',
            'estimate' => 'numeric|nullable'
		]);

        $validator = BeforeValidateTask::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('tasks.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Task', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Task', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('tasks.index'))->with('success', trans('translation.task.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Task::find($id);
        $model->delete();

        return redirect(route('tasks.index'))->with('success', trans('translation.task.destroy'));
    }

    public function list(Request $request)
    {
        //Manage filters count and filters cache
        $activeFilters = [];
        foreach ($request->all() as $filterName => $filterValue){
            if(strpos($filterName, "filter_") !== false){
                if (!empty($filterValue)){
                    $activeFilters[$filterName] = $filterValue;
                }
            }
        }
        $cacheKey = 'current_user_tasks_filter_'.Auth::user()->id;
        $cachedFilters = Cache::get($cacheKey);
        if (empty($activeFilters) && !empty($cachedFilters)){
            return redirect(route('tasks.list').'?'.http_build_query($cachedFilters));
        }
        Cache::set($cacheKey, $activeFilters);

        foreach ($activeFilters as $key => $val){
            if ($key == 'filter_change_filters' || $key == 'filter_reset'){
                unset($activeFilters[$key]);
            }
        }
        $activeFiltersCount = sizeof($activeFilters);

        //Manage filters
        $filterTaskTitle = $request->filter_task_title ?? '';
        $filterStartDueDate = $request->filter_start_due_date ?? '';
        $filterEndDueDate = $request->filter_end_due_date ?? '';
        $filterStatus = $request->filter_status ?? [];
        $filterPriority = $request->filter_priority ?? [];
        $filterUser = $request->filter_user ?? [];
        $filterTaskList = $request->filter_task_list ?? [];
        $filterBringDoneAlso = $request->filter_bring_done ?? '';
        $filterTasksDisplayed = $request->filter_tasks_displayed ?? 10;

        $user = Auth::user();
        $tasksListsIds = TaskListUser::where([
            'user_id' => $user->id
        ])->get()->pluck('tasks_lists_id')->toArray();
        $tasksLists = TaskList::whereIn('id', $tasksListsIds)->with(['tasks' => function($query) use (
            $filterTaskTitle,
            $filterStartDueDate,
            $filterEndDueDate,
            $filterStatus,
            $filterPriority,
            $filterUser,
            $filterBringDoneAlso,
            $filterTaskList
        ){
            $query = $query->with('user');

            $query = $query->orderBy('status', 'asc')
                ->orderBy('due_date', 'asc')
                ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");

            if(!empty($filterTaskTitle)){
                $query = $query->where('title', 'LIKE', '%'.$filterTaskTitle.'%');
            }

            if(!empty($filterStartDueDate)){
                $query = $query->where('due_date', '>=', $filterStartDueDate);
            }

            if(!empty($filterEndDueDate)){
                $query = $query->where('due_date', '<=', $filterEndDueDate);
            }

            if(!empty($filterStatus)){
                $query = $query->whereIn('status', $filterStatus);
            }

            if(!empty($filterPriority)){
                $query = $query->whereIn('priority', $filterPriority);
            }

            if(!empty($filterUser)){
                $query = $query->whereIn('user_id', $filterUser);
            }

            if(!empty($filterTaskList)){
                $query = $query->whereIn('tasks_lists_id', $filterTaskList);
            }

            if(!empty($filterBringDoneAlso)){
                $query = $query->whereIn('status', [
                    'pending', 'done'
                ]);
            } else{
                $query = $query->where('status', '=', 'pending');
            }

            return $query;
        }])->get();

        $priorities = ['low','medium','high'];
        $users = User::all();
        $statuses = ['pending','done'];

        $currentUser = Auth::user();
        $today = new Carbon();
        $today = $today->format('Y-m-d');

        $autoResponderTypes = [
            'none',
            'failed',
            'maternity',
            'out_of_office'
        ];

        $dealsSources = DealSource::all();
        $currencies = Currency::all();

        return view('tasks.list', compact(
            'tasksLists',
            'priorities',
            'users',
            'statuses',
            'currentUser',
            'today',
            'filterTaskTitle',
            'filterStartDueDate',
            'filterEndDueDate',
            'filterStatus',
            'filterPriority',
            'filterUser',
            'filterBringDoneAlso',
            'filterTaskList',
            'autoResponderTypes',
            'activeFiltersCount',
            'filterTasksDisplayed',
            'dealsSources',
            'currencies'
        ));
    }


    public function getTaskListReport(Request $request)
    {
        $taskList = TaskList::whereIn('id', [$request->tasks_lists_id])->with('tasks')->first();

        $taskList->reportData = $this->getTaskListReportData($taskList->tasks);

        return view('tasks.partials.task-list-report-content', compact( 'taskList'));
    }

    public function getTaskListReportData($tasks)
    {
        $users = [];
        $totals = [];
        foreach ($tasks as $task){
            $users[$task->user_id][] = [
                'overdue' => $this->getOverdue($task),
                'task' => $task
            ];
        }

        $usersData = [];
        $totalOverdue = 0;
        foreach ($users as $userTasks){
            foreach ($userTasks as $task){
                $userEmail = $task['task']->user->email;
                $usersData[$userEmail]['email'] = $userEmail;
                if(empty($usersData[$userEmail]['total_overdue'])){
                    $usersData[$userEmail]['total_overdue'] = 0;
                }
                $usersData[$userEmail]['total_overdue'] += $task['overdue'];

                if(empty($usersData[$userEmail]['total_tasks_created'])){
                    $usersData[$userEmail]['total_tasks_created'] = 0;
                }
                $usersData[$userEmail]['total_tasks_created'] += $task['task']->user->id == $task['task']->created_by_user_id ? 1 : 0;

                if(empty($usersData[$userEmail]['total_tasks'])){
                    $usersData[$userEmail]['total_tasks'] = 0;
                }
                $usersData[$userEmail]['total_tasks'] += 1;
                $usersData[$userEmail]['avg_overdue'] = number_format($usersData[$userEmail]['total_tasks'] != 0 ? $usersData[$userEmail]['total_overdue'] / $usersData[$userEmail]['total_tasks'] : 0, 2);
                $totalOverdue += $task['overdue'];
            }
        }

        $totals['tasks'] = sizeof($tasks);
        $totals['unique_users'] = sizeof($users);
        $totals['avg_tasks_per_user'] = $totals['unique_users'] != 0 ? $totals['tasks'] / $totals['unique_users'] : 0;
        $totals['avg_overdue'] = $totals['tasks'] != 0 ? $totalOverdue / $totals['tasks'] : 0;

        return [
            'users' => $usersData,
            'totals' => $totals
        ];
    }

    public function getOverdue($task)
    {
        $dueDate = new Carbon($task->due_date);
        $now = new Carbon();
        $daysDiff = $now->diffInDays($dueDate);

        if($dueDate < $now){
           return (-1) * $daysDiff;
        } else{
           $daysDiff;
        }
    }

    public function quickEdit(Request $request, $id)
    {
        $model = Task::find($id);
        $model->update($request->all());

        return redirect()->back()->with('success', trans('translation.task.update'));
    }

    public function quickAdd(Request $request)
    {
        Task::create($request->all());

        return redirect()->back()->with('success', trans('translation.task.create'));
    }

    public function markAsDone(Request $request, $id)
    {
        $model = Task::find($id);
        $model->status = 'done';
        $model->save();

        return redirect()->back()->with('success', trans('translation.task.update'));
    }

    public function coldEmailingActions(Request $request, $id)
    {
        $currentTask = Task::where([
            'id' => $id
        ])->first();
        $currentTask->auto_responder_type = $request->auto_responder_type;

        if ($request->has('create_new_task')){
            $currentTask->status = 'done';

            $data = $currentTask->toArray();
            $data['title'] = 'Postponed - '.$currentTask->title;
            $data['due_date'] = $request->due_date;
            $data['original_task_id'] = $id;
            $data['user_id'] = $request->user_id;
            $data['auto_responder_type'] = 'none';
            $data['status'] = 'pending';
            $data['description'] = $request->description;

            Task::create($data);
        }

        $currentTask->save();

        return redirect()->back()->with('success', trans('translation.task.update'));
    }

    public function coldEmailingQuickActions(Request $request, $id)
    {
        $currentTask = Task::where([
            'id' => $id
        ])->first();
        $currentTask->auto_responder_type = $request->auto_responder_type;
        $currentTask->status = 'done';
        $currentTask->save();

        return redirect()->back()->with('success', trans('translation.task.update'));
    }

    public function getContactInformation(Request $request)
    {
        $task = Task::where([
            'id' => $request->task_id
        ])->first();
        $companyContact = CompanyContact::where([
            'id' => $task->companies_contact_id
        ])->first();

        return view('tasks.partials.contact-information-content', compact('task', 'companyContact'));
    }

    public function updateContactInformation(Request $request)
    {
        $companyContact = CompanyContact::where([
            'id' => $request->id
        ])->first();

        $companyContact->update($request->all());

        return trans('translation.companyContact.update');
    }

    public function getTaskThreadMessages(Request $request)
    {
        $task = Task::where([
            'id' => $request->task_id
        ])->first();

        return view('tasks.partials.task-threads-messages-content', compact('task', 'task'));
    }

    public function coldCallingQuickActions(Request $request, $id)
    {
        $currentTask = Task::where([
            'id' => $id
        ])->first();
        $currentTask->cold_calling_status = $request->cold_calling_status;
        $currentTask->status = 'done';
        $currentTask->save();

        return redirect()->back()->with('success', trans('translation.task.update'));
    }

    public function createDeal(Request $request, $id)
    {
        $currentTask = Task::where([
            'id' => $id
        ])->first();
        $currentTask->status = 'done';
        if ($currentTask->type == 'cold_calling'){
            $currentTask->cold_calling_status = 'interested';
        }
        $currentTask->save();

        $dealStatus = DealStatus::orderBy('order', 'asc')->first();

        Deal::create([
            'user_id' => $currentTask->user_id,
            'companies_contacts_id' => $currentTask->companies_contact_id,
            'deals_statuses_id' => $dealStatus->id,
            'deals_sources_id' => $request->deals_sources_id,
            'currency_id' => $request->currency_id,
            'deal_size' => $request->deal_size,
            'type' => 'new_deal',
            'title' => 'Deal with '.$currentTask->companyContact->company->name,
            'emails_threads_id' => !empty($currentTask->emails_threads_id) ? $currentTask->emails_threads_id : null
        ]);

        $company = Company::where([
            'id' => $currentTask->companyContact->company->id
        ])->first();
        $company->type = 'prospect';
        $company->save();

        return redirect()->back()->with('success', trans('translation.task.dealCreatedSuccessfully'));
    }
}
