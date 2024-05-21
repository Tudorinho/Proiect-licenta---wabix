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
use App\Validators\BeforeValidateEventType;
use App\Models\EventType;


class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = EventType::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('color', function($row){
                    return view('components.columns.color-square', [
                        'row' => $row
                    ]);
				})
				->addColumn('created_at', function($row){
					return $row->created_at;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'events-types.edit',
						'destroy' => 'events-types.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('events-types.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('events-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'color' => 'required',
		]);

        $validator = BeforeValidateEventType::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('events-types.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('EventType', $request, Auth::user()));
        $model = EventType::create($request->all());
        event(new AfterCreate('EventType', $request, Auth::user(), $model));

        return redirect(route('events-types.index'))->with('success', trans('translation.eventType.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = EventType::find($id);

		return view('events-types.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = EventType::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'color' => 'required',
		]);

        $validator = BeforeValidateEventType::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('events-types.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('EventType', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('EventType', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('events-types.index'))->with('success', trans('translation.eventType.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = EventType::find($id);
        $model->delete();

        return redirect(route('events-types.index'))->with('success', trans('translation.eventType.destroy'));
    }
}
