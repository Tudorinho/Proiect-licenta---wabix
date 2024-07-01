<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ProjectStatus;
use App\Traits\DataTableTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateWorklog;
use App\Models\Worklog;
use App\Models\User;
use App\Models\Project;

class WorklogController extends Controller
{
    use DataTableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->getdDtRecords(Worklog::class, $request);
            $totalCount = $this->getDtTotalRecords(Worklog::class, $request);

            return Datatables::of($data)
                ->addIndexColumn()
				->addColumn('hours', function($row){
					return $row->hours;
				})
				->addColumn('employee', function($row){
					return $row->employee->first_name.' '.$row->employee->last_name;
				})
				->addColumn('project', function($row){
                    return view('components.columns.label', [
                        'text' => $row->project->name,
                        'color' => $row->project->color
                    ]);
				})
                ->addColumn('description', function($row){
                    return $row->description;
                })
                ->addColumn('date', function($row){
                    $date = new Carbon($row->date);
                    return $date->format('Y-m-d');
                })
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'worklogs.edit',
						'destroy' => 'worklogs.destroy',
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('worklogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = Auth::user();
        if ($currentUser->role == 'admin'){
            $employees = Employee::all();
        } elseif($currentUser->role == 'employee'){
            $employees = Employee::where([
                'user_id' => $currentUser->id
            ])->get();
        }

        $ongoingStatus = ProjectStatus::where([
            'is_ongoing' => 1
        ])->first();
        // dd($ongoingStatus);

		$projects = Project::where(['project_status_id' => $ongoingStatus->id])->get();
        $today = new Carbon();
        $today = $today->format('Y-m-d');

		return view('worklogs.create', compact('employees','projects', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'hours' => 'required|numeric',
			'employee_id' => 'required',
			'project_id' => 'required',
			'description' => 'required'
		]);

        $validator = BeforeValidateWorklog::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('worklogs.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Worklog', $request, Auth::user()));
        $model = Worklog::create($request->all());
        event(new AfterCreate('Worklog', $request, Auth::user(), $model));

        return redirect(route('worklogs.index'))->with('success', trans('translation.worklog.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = Worklog::find($id);

        $currentUser = Auth::user();
        if($currentUser->role == 'employee'){
            $employee = Employee::where([
                'user_id' => $currentUser->id
            ])->first();

            if ($model->employee_id != $employee->id){
                return redirect(route('worklogs.index'))->with('error', trans('translation.worklog.notAllowedToModify'));
            }

            $employees = Employee::where([
                'user_id' => $currentUser->id
            ])->get();
        } else{
            $employees = Employee::all();
        }

		$projects = Project::all();

		return view('worklogs.edit', compact('employees','projects', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Worklog::find($id);

        $currentUser = Auth::user();
        if($currentUser->role == 'employee'){
            $employee = Employee::where([
                'user_id' => $currentUser->id
            ])->first();

            if ($model->employee_id != $employee->id){
                return redirect(route('worklogs.index'))->with('error', trans('translation.worklog.notAllowedToModify'));
            }
        }

		$validator = Validator::make($request->all(), [
			'hours' => 'required|numeric',
			'employee_id' => 'required',
			'project_id' => 'required',
            'description' => 'required'
		]);

        $validator = BeforeValidateWorklog::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('worklogs.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Worklog', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Worklog', $request, Auth::user(), $model));

        return redirect(route('worklogs.index'))->with('success', trans('translation.worklog.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Worklog::find($id);
        $model->delete();

        return redirect(route('worklogs.index'))->with('success', trans('translation.worklog.destroy'));
    }

    public function report(Request $request)
    {
        $ongoingStatus = ProjectStatus::where([
            'is_ongoing' => 1
        ])->first();
        $projects = Project::where(['project_status_id' => $ongoingStatus->id])->get();
        $employees = Employee::all();

        $project_id = $request->project_id ?? 0;
        $employee_id = $request->employee_id ?? 0;
        $start_date = $request->start_date;
        $end_date = $request->end_date;


        $worklogs = Worklog::where([]);
        if (!empty($project_id)){
            $worklogs = $worklogs->where([
                'project_id' => $project_id
            ]);
        }
        if (!empty($employee_id)){
            $worklogs = $worklogs->where([
                'employee_id' => $employee_id
            ]);
        }
        if (!empty($start_date)){
            $worklogs = $worklogs->where('date', '>=', $start_date);
        }
        if (!empty($end_date)){
            $worklogs = $worklogs->where('date', '<=', $end_date);
        }

        $worklogs = $worklogs->orderBy('employee_id','desc')
            ->orderBy('project_id','desc')
            ->orderBy('date','desc');
        $worklogs = $worklogs->get();

        $totals = [];
        foreach ($worklogs as $worklog){
            if(empty($totals[$worklog->employee->first_name.' '.$worklog->employee->last_name][$worklog->project->name])){
                $totals[$worklog->employee->first_name.' '.$worklog->employee->last_name][$worklog->project->name] = 0;
            }

            $totals[$worklog->employee->first_name.' '.$worklog->employee->last_name][$worklog->project->name] += $worklog->hours;
        }

        if($request->download == 1){
            $exportData = [];
            $exportData[] = [
                'employee' => 'Employee',
                'project' => 'Project',
                'date' => 'Date',
                'hours' => 'Hours',
                'description' => 'Description',
            ];

            foreach ($worklogs as $worklog){
                $exportData[] = [
                    'employee' => $worklog->employee->first_name.' '.$worklog->employee->last_name,
                    'project' => $worklog->project->name,
                    'date' => $worklog->date,
                    'hours' => $worklog->hours,
                    'description' => $worklog->description
                ];
            }

            return $this->array_to_csv_download($exportData, 'worklogs.csv', ',');
        }

        return view('worklogs.report', compact('projects', 'employees', 'project_id', 'employee_id', 'start_date', 'end_date', 'worklogs', 'totals'));
    }

    function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w');
        // loop over the input array
        foreach ($array as $line) {
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter);
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: text/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    }

}
