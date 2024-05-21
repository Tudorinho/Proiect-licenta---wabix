<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateEmployee;
use App\Models\Employee;
use App\Models\User;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Employee::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('first_name', function($row){
					return $row->first_name;
				})
				->addColumn('last_name', function($row){
					return $row->last_name;
				})
				->addColumn('gender', function($row){
					return $row->gender;
				})
				->addColumn('date_of_birth', function($row){
					return $row->date_of_birth;
				})
				->addColumn('user_id', function($row){
					return $row->user->first_name.' '.$row->user->last_name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'employees.edit',
						'destroy' => 'employees.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('employees.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$genders = ['male','female','other'];
		$users = User::all();

		return view('employees.create', compact('genders','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'gender' => 'required|max:255',
			'date_of_birth' => 'required',
			'user_id' => 'required',
		]);

        $validator = BeforeValidateEmployee::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('employees.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Employee', $request, Auth::user()));
        $model = Employee::create($request->all());
        event(new AfterCreate('Employee', $request, Auth::user(), $model));

        return redirect(route('employees.index'))->with('success', trans('translation.employee.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$genders = ['male','female','other'];
		$users = User::all();

        $model = Employee::find($id);

		return view('employees.edit', compact('genders','users', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Employee::find($id);

		$validator = Validator::make($request->all(), [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'gender' => 'required|max:255',
			'date_of_birth' => 'required',
			'user_id' => 'required',
		]);

        $validator = BeforeValidateEmployee::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('employees.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Employee', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Employee', $request, Auth::user(), $model));

        return redirect(route('employees.index'))->with('success', trans('translation.employee.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Employee::find($id);
        $model->delete();

        return redirect(route('employees.index'))->with('success', trans('translation.employee.destroy'));
    }

    public function quickSearch(Request $request)
    {
        $data = Employee::where('first_name', 'like', '%'.$request->keyword.'%')
            ->orWhere('last_name', 'like', '%'.$request->keyword.'%')->get();

        $results = [];
        foreach ($data as $value){
            $results[] = [
                'text' => $value->first_name.' '.$value->last_name,
                'id' => $value->id
            ];
        }

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => false
            ]
        ]);
    }
}
