<?php

namespace App\Http\Controllers;

use App\Models\ProjectPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ProjectPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProjectPriority::get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return view('components.columns.actions', [
                        'row' => $row,
                        'edit' => 'projects-priorities.edit',
                        'destroy' => 'projects-priorities.destroy'
                    ]);
                })
                ->addColumn('color', function($row){
                    return view('components.columns.color-square', [
                        'row' => $row
                    ]);
                })
                ->rawColumns(['action', 'color'])
                ->make(true);
        }

        return view('projects-priorities.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects-priorities.create');
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
            return redirect(route('projects-priorities.create'))->withErrors($validator->errors());
        }

        $model = ProjectPriority::create($request->all());

        return redirect(route('projects-priorities.index'))->with('success', trans('translation.projectPriority.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = ProjectPriority::find($id);

        return view('projects-priorities.edit', compact('model'));
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
            return redirect(route('projects-priorities.edit', ['id' => $id]))->withErrors($validator->errors());
        }

        $model = ProjectPriority::find($id);
        $model->update($request->all());

        return redirect(route('projects-priorities.index'))->with('success', trans('translation.projectPriority.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ProjectPriority::find($id);
        $model->delete();

        return redirect(route('projects-priorities.index'))->with('success', trans('translation.projectPriority.destroy'));
    }
}
