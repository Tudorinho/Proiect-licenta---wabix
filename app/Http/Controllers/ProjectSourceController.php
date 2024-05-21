<?php
namespace App\Http\Controllers;

use App\Models\ProjectSource;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ProjectSourceController extends Controller
{
    public function index(Request $request)
    {
        $data = ProjectSource::get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return view('components.columns.actions', [
                        'row' => $row,
                        'edit' => 'projects-sources.edit',
                        'destroy' => 'projects-sources.destroy'
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('projects-sources.index', compact('data'));
    }

    public function create()
    {
        return view('projects-sources.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects-sources.create'))->withErrors($validator->errors());
        }

        ProjectSource::create($request->all());

        return redirect(route('projects-sources.index'))->with('success', trans('translation.projectSource.store'));
    }

    public function edit($id)
    {
        $model = ProjectSource::find($id);

        return view('projects-sources.edit', compact(['model']));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects-sources.edit', ['id' => $id]))->withErrors($validator->errors());
        }

        $model = ProjectSource::find($id);
        $model->update($request->all());

        return redirect(route('projects-sources.index'))->with('success', trans('translation.projectSource.update'));
    }

    public function destroy($id)
    {
        $model = ProjectSource::find($id);
        $model->delete();

        return redirect(route('projects-sources.index'))->with('success', trans('translation.projectSource.destroy'));
    }
}
