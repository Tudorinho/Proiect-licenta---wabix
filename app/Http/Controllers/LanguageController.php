<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\DataTableTrait;
use DataTables;

class LanguageController extends Controller
{
    use DataTableTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->getdDtRecords(Language::class, $request);
            $totalCount = $this->getDtTotalRecords(Language::class, $request);

            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'languages.edit',
						'destroy' => 'languages.destroy',
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('languages.index');
    }


    public function create()
    {
        return view('languages.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:languages,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $language = Language::create($request->all());

        return redirect()->route('languages.index')->with('success', 'Language created successfully!');
    }


    public function edit($id)
    {
        $language = Language::find($id);
        return view('languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        $language = Language::find($id);

        if ($validator->fails()) {
            return redirect(route('languages.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        $language->update($request->all());

        return redirect()->route('languages.index')->with('success', 'Language updated successfully!');
    }

    public function destroy($id)
    {
        $language = Language::find($id);
        if (!$language) {
            return redirect(route('languages.index'))->with('error', 'Language not found.');
        }

        $language->delete();

        return redirect(route('languages.index'))->with('success', 'Language deleted successfully.');
    }
}
