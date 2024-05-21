<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProjectStatus::get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return view('components.columns.actions', [
                        'row' => $row,
                        'edit' => 'projects-statuses.edit',
                        'destroy' => 'projects-statuses.destroy'
                    ]);
                })
                ->addColumn('color', function($row){
                    return view('components.columns.color-square', [
                        'row' => $row
                    ]);
                })
                ->addColumn('is_ongoing', function($row) use ($data){
                    return view('components.columns.switcher', [
                        'row' => $row,
                        'field' => 'is_ongoing',
                        'route' => 'projects-statuses.update-is-ongoing'
                    ]);
                })
                ->rawColumns(['action', 'color', 'is_ongoing'])
                ->make(true);
        }

        return view('projects-statuses.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'color' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects-statuses.create'))->withErrors($validator->errors());
        }

        $model = ProjectStatus::create($request->all());

        $this->switchOngoing($model, $model->is_ongoing);

        return redirect(route('projects-statuses.index'))->with('success', trans('translation.projectStatus.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = ProjectStatus::find($id);

        return view('projects-statuses.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects-statuses.edit', ['id' => $id]))->withErrors($validator->errors());
        }

        $model = ProjectStatus::find($id);
        $model->update($request->all());

        $this->switchOngoing($model, $model->is_ongoing);

        return redirect(route('projects-statuses.index'))->with('success', trans('translation.projectStatus.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ProjectStatus::find($id);
        $model->delete();

        return redirect(route('projects-statuses.index'))->with('success', trans('translation.projectStatus.destroy'));
    }

    public function updateIsOngoing($id)
    {
        $model = ProjectStatus::find($id);

        $this->switchOngoing($model, $model->is_ongoing == 1 ? 0 : 1);

        return redirect(route('projects-statuses.index'))->with('success', trans('translation.general.recordUpdated'));
    }

    public function switchOngoing($model, $value)
    {
        if($value == 1){
            $projectStatuses = ProjectStatus::where('id', '!=', $model->id)->get();
            foreach ($projectStatuses as $projectStatus){
                $projectStatus->is_ongoing = 0;
                $projectStatus->save();
            }
        }

        $model->is_ongoing = $value;
        $model->save();
    }
}
