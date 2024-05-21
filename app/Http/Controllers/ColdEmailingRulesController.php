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
use App\Validators\BeforeValidateColdEmailingRules;
use App\Models\ColdEmailingRules;
use App\Models\ColdEmailingCredentials;
use App\Models\TaskList;
use App\Models\User;

class ColdEmailingRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ColdEmailingRules::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('cold_emailing_credentials_id', function($row){
					return $row->coldEmailingCredential->email;
				})
				->addColumn('subject', function($row){
					return $row->subject;
				})
				->addColumn('last_check_date', function($row){
					return $row->last_check_date;
				})
				->addColumn('tasks_lists_id', function($row){
					return $row->taskList->name;
				})
                ->addColumn('user_id', function($row){
                    return $row->user->email;
                })
                ->addColumn('last_error', function($row){
                    return $row->last_error;
                })
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'cold-emailing-rules.edit',
						'destroy' => 'cold-emailing-rules.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('cold-emailing-rules.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$coldEmailingCredentials = ColdEmailingCredentials::all();
		$tasksLists = TaskList::all();
		$users = User::all();

		return view('cold-emailing-rules.create', compact('coldEmailingCredentials','tasksLists','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'cold_emailing_credentials_id' => 'required',
		]);

        $validator = BeforeValidateColdEmailingRules::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('cold-emailing-rules.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('ColdEmailingRules', $request, Auth::user()));
        $model = ColdEmailingRules::create($request->all());
        event(new AfterCreate('ColdEmailingRules', $request, Auth::user(), $model));

        return redirect(route('cold-emailing-rules.index'))->with('success', trans('translation.coldEmailingRules.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$coldEmailingCredentials = ColdEmailingCredentials::all();
		$tasksLists = TaskList::all();
		$users = User::all();

        $model = ColdEmailingRules::find($id);

		return view('cold-emailing-rules.edit', compact('coldEmailingCredentials','tasksLists','users', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = ColdEmailingRules::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'cold_emailing_credentials_id' => 'required',
		]);

        $validator = BeforeValidateColdEmailingRules::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('cold-emailing-rules.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('ColdEmailingRules', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('ColdEmailingRules', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('cold-emailing-rules.index'))->with('success', trans('translation.coldEmailingRules.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ColdEmailingRules::find($id);
        $model->delete();

        return redirect(route('cold-emailing-rules.index'))->with('success', trans('translation.coldEmailingRules.destroy'));
    }
}
