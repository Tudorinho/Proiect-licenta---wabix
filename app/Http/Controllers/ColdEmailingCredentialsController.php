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
use App\Validators\BeforeValidateColdEmailingCredentials;
use App\Models\ColdEmailingCredentials;


class ColdEmailingCredentialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ColdEmailingCredentials::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('email', function($row){
					return $row->email;
				})
				->addColumn('username', function($row){
					return $row->username;
				})
				->addColumn('validated', function($row){
					return $row->validated;
				})
				->addColumn('last_error', function($row){
					return $row->last_error;
				})
				->addColumn('created_at', function($row){
					return $row->created_at;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'cold-emailing-credentials.edit',
						'destroy' => 'cold-emailing-credentials.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('cold-emailing-credentials.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('cold-emailing-credentials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'username' => 'required',
			'password' => 'required',
		]);

        $validator = BeforeValidateColdEmailingCredentials::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('cold-emailing-credentials.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('ColdEmailingCredentials', $request, Auth::user()));
        $model = ColdEmailingCredentials::create(array_merge($request->all(), ['validated' => 1]));
        event(new AfterCreate('ColdEmailingCredentials', $request, Auth::user(), $model));

        return redirect(route('cold-emailing-credentials.index'))->with('success', trans('translation.coldEmailingCredentials.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = ColdEmailingCredentials::find($id);

		return view('cold-emailing-credentials.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = ColdEmailingCredentials::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'username' => 'required',
			'password' => 'required',
		]);

        $validator = BeforeValidateColdEmailingCredentials::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('cold-emailing-credentials.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('ColdEmailingCredentials', $request, Auth::user(), $model));
        $model->update(array_merge($request->all(), ['validated' => 1, 'last_error' => '']));
        event(new AfterUpdate('ColdEmailingCredentials', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('cold-emailing-credentials.index'))->with('success', trans('translation.coldEmailingCredentials.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ColdEmailingCredentials::find($id);
        $model->delete();

        return redirect(route('cold-emailing-credentials.index'))->with('success', trans('translation.coldEmailingCredentials.destroy'));
    }
}
