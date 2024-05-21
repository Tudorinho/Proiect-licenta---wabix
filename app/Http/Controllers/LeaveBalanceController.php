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
use App\Validators\BeforeValidateLeaveBalance;
use App\Models\LeaveBalance;
use App\Models\Employee;
use App\Models\LeaveType;

class LeaveBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = LeaveBalance::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('employee_id', function($row){
					return $row->employee->first_name.' '.$row->employee->last_name;
				})
				->addColumn('leave_type_id', function($row){
					return $row->leaveType->name;
				})
				->addColumn('balance', function($row){
					return $row->balance;
				})
				->addColumn('year', function($row){
					return $row->year;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'leaves-balances.edit',
						'destroy' => 'leaves-balances.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('leaves-balances.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$employees = Employee::all();
		$leavesTypes = LeaveType::all();

		return view('leaves-balances.create', compact('employees','leavesTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'employee_id' => 'required',
			'leaves_types_id' => 'required',
			'year' => 'required',
		]);

        $validator = BeforeValidateLeaveBalance::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('leaves-balances.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('LeaveBalance', $request, Auth::user()));
        $model = LeaveBalance::create($request->all());
        event(new AfterCreate('LeaveBalance', $request, Auth::user(), $model));

        return redirect(route('leaves-balances.index'))->with('success', trans('translation.leaveBalance.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$employees = Employee::all();
		$leavesTypes = LeaveType::all();

        $model = LeaveBalance::find($id);

		return view('leaves-balances.edit', compact('employees','leavesTypes', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = LeaveBalance::find($id);

		$validator = Validator::make($request->all(), [
			'employee_id' => 'required',
			'leaves_types_id' => 'required',
			'year' => 'required',
		]);

        $validator = BeforeValidateLeaveBalance::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('leaves-balances.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('LeaveBalance', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('LeaveBalance', $request, Auth::user(), $model));

        return redirect(route('leaves-balances.index'))->with('success', trans('translation.leaveBalance.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = LeaveBalance::find($id);
        $model->delete();

        return redirect(route('leaves-balances.index'))->with('success', trans('translation.leaveBalance.destroy'));
    }
}
