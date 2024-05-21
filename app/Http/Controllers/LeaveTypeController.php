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
use App\Validators\BeforeValidateLeaveType;
use App\Models\LeaveType;


class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = LeaveType::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('is_paid', function($row){
					return $row->is_paid;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'leaves-types.edit',
						'destroy' => 'leaves-types.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('leaves-types.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$isPaidValues = [0,1];

		return view('leaves-types.create', compact('isPaidValues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'is_paid' => 'required',
		]);

        $validator = BeforeValidateLeaveType::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('leaves-types.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('LeaveType', $request, Auth::user()));
        $model = LeaveType::create($request->all());
        event(new AfterCreate('LeaveType', $request, Auth::user(), $model));

        return redirect(route('leaves-types.index'))->with('success', trans('translation.leaveType.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$isPaidValues = [0,1];

        $model = LeaveType::find($id);

		return view('leaves-types.edit', compact('isPaidValues', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = LeaveType::find($id);

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'is_paid' => 'required',
		]);

        $validator = BeforeValidateLeaveType::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('leaves-types.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('LeaveType', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('LeaveType', $request, Auth::user(), $model));

        return redirect(route('leaves-types.index'))->with('success', trans('translation.leaveType.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = LeaveType::find($id);
        $model->delete();

        return redirect(route('leaves-types.index'))->with('success', trans('translation.leaveType.destroy'));
    }
}
