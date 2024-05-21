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
use App\Validators\BeforeValidateDealStatus;
use App\Models\DealStatus;


class DealStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DealStatus::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('order', function($row){
					return $row->order;
				})
				->addColumn('color', function($row){
                    return view('components.columns.color-square', [
                        'row' => $row
                    ]);
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'deals-statuses.edit',
						'destroy' => 'deals-statuses.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('deals-statuses.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('deals-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'order' => 'required',
			'color' => 'required',
		]);

        $validator = BeforeValidateDealStatus::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('deals-statuses.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('DealStatus', $request, Auth::user()));
        $model = DealStatus::create($request->all());
        event(new AfterCreate('DealStatus', $request, Auth::user(), $model));

        return redirect(route('deals-statuses.index'))->with('success', trans('translation.dealsStatuses.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = DealStatus::find($id);

		return view('deals-statuses.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = DealStatus::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'order' => 'required',
			'color' => 'required',
		]);

        $validator = BeforeValidateDealStatus::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('deals-statuses.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('DealStatus', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('DealStatus', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('deals-statuses.index'))->with('success', trans('translation.dealsStatuses.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = DealStatus::find($id);
        $model->delete();

        return redirect(route('deals-statuses.index'))->with('success', trans('translation.dealsStatuses.destroy'));
    }
}
