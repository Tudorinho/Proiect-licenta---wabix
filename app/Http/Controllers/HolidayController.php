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
use App\Validators\BeforeValidateHoliday;
use App\Models\Holiday;


class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Holiday::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('start_date', function($row){
					return $row->start_date;
				})
				->addColumn('end_date', function($row){
					return $row->end_date;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'holidays.edit',
						'destroy' => 'holidays.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('holidays.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		]);

        $validator = BeforeValidateHoliday::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('holidays.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Holiday', $request, Auth::user()));
        $model = Holiday::create($request->all());
        event(new AfterCreate('Holiday', $request, Auth::user(), $model));

        return redirect(route('holidays.index'))->with('success', trans('translation.holiday.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = Holiday::find($id);

		return view('holidays.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Holiday::find($id);

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		]);

        $validator = BeforeValidateHoliday::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('holidays.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Holiday', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Holiday', $request, Auth::user(), $model));

        return redirect(route('holidays.index'))->with('success', trans('translation.holiday.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Holiday::find($id);
        $model->delete();

        return redirect(route('holidays.index'))->with('success', trans('translation.holiday.destroy'));
    }
}
