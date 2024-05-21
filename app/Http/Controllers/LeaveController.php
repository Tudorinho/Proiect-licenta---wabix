<?php
namespace App\Http\Controllers;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateLeave;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Leave::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('employee_id', function($row){
					return $row->employee->first_name.' '.$row->employee->last_name;
				})
				->addColumn('leave_type_id', function($row){
					return $row->leaveType->name;
				})
				->addColumn('start_date', function($row){
					return $row->start_date;
				})
				->addColumn('end_date', function($row){
					return $row->end_date;
				})
				->addColumn('status', function($row){
					return $row->status;
				})
                ->addColumn('leave_days', function($row){
                    return $row->leave_days;
                })
                ->addColumn('holiday_days', function($row){
                    return $row->holiday_days;
                })
                ->addColumn('weekend_days', function($row){
                    return $row->weekend_days;
                })
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'leaves.edit',
						'destroy' => 'leaves.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('leaves.index', compact('data'));
    }

    public function calendar(Request $request)
    {
        $data = Leave::get();
        $events = [];
        $holidays = Holiday::all();

        foreach ($holidays as $holiday){
            $start = new Carbon($holiday->start_date);
            $end = new Carbon($holiday->end_date);
            $end->addDay();

            $events[] = [
                'title' => $holiday->name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'color' => 'black',
                'textColor' => 'yellow'
            ];
        }

        foreach ($data as $leave){
            $start = new Carbon($leave->start_date);
            $end = new Carbon($leave->end_date);
            $end->addDay();

            $color = '#'.bin2hex($leave->employee->first_name.' '.$leave->employee->last_name);

            $events[] = [
                'title' => $leave->employee->first_name.' '.$leave->employee->last_name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'color' => $color,
                'textColor' => $this->getContrastColor($color)
            ];
        }
        $events = json_encode($events);

        return view('leaves.calendar', compact('events'));
    }

    public function getContrastColor($hexcolor)
    {
        $r = hexdec(substr($hexcolor, 1, 2));
        $g = hexdec(substr($hexcolor, 3, 2));
        $b = hexdec(substr($hexcolor, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? 'black' : 'white';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$employees = Employee::all();
		$leavesTypes = LeaveType::all();
		$statuses = ['pending'];

		return view('leaves.create', compact('employees','leavesTypes','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'employee_id' => 'required',
			'leaves_types_id' => 'required',
			'start_date' => 'required|after:today',
			'end_date' => 'required',
			'status' => 'required',
		]);

        $validator = BeforeValidateLeave::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('leaves.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Leave', $request, Auth::user()));
        $model = Leave::create($this->setModelDays($request));
        event(new AfterCreate('Leave', $request, Auth::user(), $model));

        return redirect(route('leaves.index'))->with('success', trans('translation.leave.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$employees = Employee::all();
		$leavesTypes = LeaveType::all();
		$statuses = ['pending','approved','rejected'];

        $model = Leave::find($id);

		return view('leaves.edit', compact('employees','leavesTypes','statuses', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Leave::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'status' => 'required',
		]);

        $validator = BeforeValidateLeave::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('leaves.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Leave', $request, Auth::user(), $model));
        $model->update($this->setModelDays($request, $model));
        event(new AfterUpdate('Leave', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('leaves.index'))->with('success', trans('translation.leave.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Leave::find($id);
        $model->delete();

        return redirect(route('leaves.index'))->with('success', trans('translation.leave.destroy'));
    }

    public function setModelDays($request, $model = null)
    {
        if (!empty($model)){
            $data = Leave::getData($model->start_date, $model->end_date);
        } else{
            $data = Leave::getData($request->start_date, $request->end_date);
        }

        $startDate = $data[0];
        $endDate = $data[1];
        $startDateYear = $data[2];
        $endDateYear = $data[3];
        $leaveDays = $data[4];
        $weekendDays = $data[5];
        $holidayDays = $data[6];
        $totalDays = $data[7];
        $daysBeforeLeave = $data[8];

        $days['leave_days'] = $leaveDays;
        $days['weekend_days'] = $weekendDays;
        $days['holiday_days'] = $holidayDays;
        $days['year'] = $startDateYear;

        return array_merge($request->all(), $days);
    }
}
