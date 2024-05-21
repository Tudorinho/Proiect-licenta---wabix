<?php

namespace App\Http\Controllers;

use App\Models\ProjectContractType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ProjectContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProjectContractType::get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return view('components.columns.actions', [
                        'row' => $row,
                        'edit' => 'projects-contracts-types.edit',
                        'destroy' => 'projects-contracts-types.destroy'
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

        return view('projects-contracts-types.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects-contracts-types.create');
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
            return redirect(route('projects-contracts-types.create'))->withErrors($validator->errors());
        }

        $model = ProjectContractType::create($request->all());

        return redirect(route('projects-contracts-types.index'))->with('success', trans('translation.projectContractType.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = ProjectContractType::find($id);

        return view('projects-contracts-types.edit', compact('model'));
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
            return redirect(route('projects-contracts-types.edit', ['id' => $id]))->withErrors($validator->errors());
        }

        $model = ProjectContractType::find($id);
        $model->update($request->all());

        return redirect(route('projects-contracts-types.index'))->with('success', trans('translation.projectContractType.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ProjectContractType::find($id);
        $model->delete();

        return redirect(route('projects-contracts-types.index'))->with('success', trans('translation.projectContractType.destroy'));
    }
}
