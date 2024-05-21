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
use App\Validators\BeforeValidateWikiArticle;
use App\Models\WikiArticle;
use App\Models\WikiCategory;

class WikiArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = WikiArticle::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('title', function($row){
					return $row->title;
				})
				->addColumn('wiki_categories_id', function($row){
					return $row->wikiCategory->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'wiki-articles.edit',
						'destroy' => 'wiki-articles.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('wiki-articles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$wikiCategories = WikiCategory::all();

		return view('wiki-articles.create', compact('wikiCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'body' => 'required',
			'wiki_categories_id' => 'required',
		]);

        $validator = BeforeValidateWikiArticle::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('wiki-articles.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('WikiArticle', $request, Auth::user()));
        $model = WikiArticle::create($request->all());
        event(new AfterCreate('WikiArticle', $request, Auth::user(), $model));

        return redirect(route('wiki-articles.index'))->with('success', trans('translation.wikiArticle.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$wikiCategories = WikiCategory::all();

        $model = WikiArticle::find($id);

		return view('wiki-articles.edit', compact('wikiCategories', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = WikiArticle::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'body' => 'required',
			'wiki_categories_id' => 'required',
		]);

        $validator = BeforeValidateWikiArticle::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('wiki-articles.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('WikiArticle', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('WikiArticle', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('wiki-articles.index'))->with('success', trans('translation.wikiArticle.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = WikiArticle::find($id);
        $model->delete();

        return redirect(route('wiki-articles.index'))->with('success', trans('translation.wikiArticle.destroy'));
    }

    public function wiki(Request $request, $wikiCategoryId = null, $wikiArticleId = null)
    {
        $wikiCategories = WikiCategory::all();
        $wikiArticles = [];
        $currentWikiArticle = null;
        if(!empty($wikiCategoryId)){
            $wikiArticles = WikiArticle::where([
                'wiki_categories_id' => $wikiCategoryId
            ])->get();
        }

        if (!empty($wikiArticleId)){
            $currentWikiArticle = WikiArticle::where([
                'id' => $wikiArticleId
            ])->first();
        }
        return view('wiki-articles.wiki', compact('wikiCategories', 'wikiArticles', 'wikiCategoryId', 'wikiArticleId', 'currentWikiArticle'));
    }
}
