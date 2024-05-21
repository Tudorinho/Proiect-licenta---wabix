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
use App\Validators\BeforeValidateWikiCategory;
use App\Models\WikiCategory;


class WikiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = WikiCategory::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'wiki-categories.edit',
						'destroy' => 'wiki-categories.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('wiki-categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

		return view('wiki-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

        $validator = BeforeValidateWikiCategory::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('wiki-categories.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('WikiCategory', $request, Auth::user()));
        $model = WikiCategory::create($request->all());
        event(new AfterCreate('WikiCategory', $request, Auth::user(), $model));

        return redirect(route('wiki-categories.index'))->with('success', trans('translation.wikiCategory.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $model = WikiCategory::find($id);

		return view('wiki-categories.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = WikiCategory::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

        $validator = BeforeValidateWikiCategory::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('wiki-categories.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('WikiCategory', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('WikiCategory', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('wiki-categories.index'))->with('success', trans('translation.wikiCategory.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = WikiCategory::find($id);
        $model->delete();

        return redirect(route('wiki-categories.index'))->with('success', trans('translation.wikiCategory.destroy'));
    }
}
