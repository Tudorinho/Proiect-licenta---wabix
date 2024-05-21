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
use App\Validators\BeforeValidateCurrency;
use App\Models\Currency;


class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Currency::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('symbol', function($row){
					return $row->symbol;
				})
				->addColumn('rate', function($row){
					return $row->rate;
				})
				->addColumn('is_default', function($row){
					return $row->is_default;
				})
				->addColumn('created_at', function($row){
					return $row->created_at;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'currencies.edit',
						'destroy' => 'currencies.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('currencies.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$isDefaultValues = [1,0];

		return view('currencies.create', compact('isDefaultValues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'symbol' => 'required',
		]);

        $validator = BeforeValidateCurrency::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('currencies.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Currency', $request, Auth::user()));
        $model = Currency::create($request->all());
        event(new AfterCreate('Currency', $request, Auth::user(), $model));

        return redirect(route('currencies.index'))->with('success', trans('translation.user.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$isDefaultValues = [1,0];

        $model = Currency::find($id);

		return view('currencies.edit', compact('isDefaultValues', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Currency::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'symbol' => 'required',
		]);

        $validator = BeforeValidateCurrency::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('currencies.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Currency', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Currency', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('currencies.index'))->with('success', trans('translation.user.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Currency::find($id);
        $model->delete();

        return redirect(route('currencies.index'))->with('success', trans('translation.user.destroy'));
    }
}
