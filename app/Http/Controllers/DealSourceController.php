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
use App\Validators\BeforeValidateDealSource;
use App\Models\DealSource;


class DealSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DealSource::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
                ->addColumn('is_default', function($row){
                    return $row->is_default;
                })
				->addColumn('action', function($row){
                    if ($row->is_default){
                        return '';
                    }
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'deals-sources.edit',
						'destroy' => 'deals-sources.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('deals-sources.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('deals-sources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

        $validator = BeforeValidateDealSource::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('deals-sources.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('DealSource', $request, Auth::user()));
        $model = DealSource::create($request->all());
        event(new AfterCreate('DealSource', $request, Auth::user(), $model));

        return redirect(route('deals-sources.index'))->with('success', trans('translation.dealsSources.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = DealSource::find($id);

		return view('deals-sources.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = DealSource::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

        $validator = BeforeValidateDealSource::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('deals-sources.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('DealSource', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('DealSource', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('deals-sources.index'))->with('success', trans('translation.dealsSources.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = DealSource::find($id);
        $model->delete();

        return redirect(route('deals-sources.index'))->with('success', trans('translation.dealsSources.destroy'));
    }
}
