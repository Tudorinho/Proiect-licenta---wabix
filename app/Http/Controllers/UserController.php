<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateUser;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = User::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('email', function($row){
					return $row->email;
				})
				->addColumn('role', function($row){
					return $row->role;
				})
				->addColumn('created_at', function($row){
					return $row->created_at;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'users.edit',
						'destroy' => 'users.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$roles = ['employee','admin'];

		return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
			'role' => 'required',
		]);

        $validator = BeforeValidateUser::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('users.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('User', $request, Auth::user()));
        $data = $request->all();
        $data['avatar'] = 'images/avatar.jpg';
        $date = new Carbon();
        $data['email_verified_at'] = $date->format('Y-m-d G:i:s');
        $data['password'] = Hash::make($request->password);
        $model = User::create($data);
        event(new AfterCreate('User', $request, Auth::user(), $model));

        return redirect(route('users.index'))->with('success', trans('translation.user.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$roles = ['employee','admin'];

        $model = User::find($id);

		return view('users.edit', compact('roles', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = User::find($id);

		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
			'role' => 'required',
		]);

        $validator = BeforeValidateUser::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('users.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('User', $request, Auth::user(), $model));
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $model->update($data);
        event(new AfterUpdate('User', $request, Auth::user(), $model));

        return redirect(route('users.index'))->with('success', trans('translation.user.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = User::find($id);
        $model->delete();

        return redirect(route('users.index'))->with('success', trans('translation.user.destroy'));
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $currentUser = User::where([
            'id' => Auth::user()->id
        ])->first();
        $checkHash = Hash::check($request->current_password, $currentUser->password);
        if ($checkHash == false){
            return redirect(route('users.profile'))->withInput()->withErrors([
                'current_password' => "Current password do not match."
            ]);
        }

        if ($validator->fails()) {
            return redirect(route('users.profile'))->withInput()->withErrors($validator->errors());
        }

        $currentUser->password = Hash::make($request->new_password);
        $currentUser->save();

        return redirect(route('users.profile'))->with('success', trans('translation.user.update'));
    }
}
