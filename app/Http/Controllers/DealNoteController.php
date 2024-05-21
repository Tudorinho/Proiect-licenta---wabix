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
use App\Validators\BeforeValidateDealNote;
use App\Models\DealNote;
use App\Models\Deal;

class DealNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DealNote::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('deals_id', function($row){
					return $row->deal->title;
				})
				->addColumn('note', function($row){
					return $row->note;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'deals-notes.edit',
						'destroy' => 'deals-notes.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('deals-notes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$deals = Deal::all();

		return view('deals-notes.create', compact('deals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'deals_id' => 'required',
			'note' => 'required',
		]);

        $validator = BeforeValidateDealNote::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('error', trans('translation.dealsNotes.failedToCreate'));;
        }

        event(new BeforeCreate('DealNote', $request, Auth::user()));
        $model = DealNote::create($request->all());
        event(new AfterCreate('DealNote', $request, Auth::user(), $model));

        return redirect()->back()->with('success', trans('translation.dealsNotes.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$deals = Deal::all();

        $model = DealNote::find($id);

		return view('deals-notes.edit', compact('deals', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = DealNote::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'deals_id' => 'required',
			'note' => 'required',
		]);

        $validator = BeforeValidateDealNote::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('deals-notes.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('DealNote', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('DealNote', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('deals-notes.index'))->with('success', trans('translation.dealsNotes.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = DealNote::find($id);
        $model->delete();

        return redirect(route('deals-notes.index'))->with('success', trans('translation.dealsNotes.destroy'));
    }
}
