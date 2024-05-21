<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use App\Models\Language;
use App\Models\DocumentFolderFile;
use Illuminate\Http\Request;

class DocumentFolderFileController extends Controller
{
    public function create()
    {
        $languages = Language::all();
        return view('document-folders.create-file', compact('languages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'data' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'language_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect(route('document-folders.create-file'))->withInput()->withErrors($validator->errors());
        }

        $file = DocumentFolderFile::create($request->all());

        return redirect(route('document-folders.index', ['document_folder_id' => $request->document_folder_id]))
        ->with('success', 'File created successfully.');
    }

    public function edit($id)
    {
        $file = DocumentFolderFile::find($id);
        $languages = Language::all();
        return view('document-folders.edit-file', compact('file', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'data' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'language_id' => 'required|string',
        ]);

        $file = DocumentFolderFile::find($id);

        if ($validator->fails()) {
            return redirect(route('document-folders.edit-file', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        $file->update($request->all());

        return redirect(route('document-folders.index', ['document_folder_id' => $file->document_folder_id]))
        ->with('success', 'File updated successfully.');
    }

    public function destroy($id)
    {
        $file = DocumentFolderFile::find($id);
        if (!$file) {
            return redirect(route('document-folders.index'))->with('error', 'File not found.');
        }

        $folderId = $file->document_folder_id;
        $file->delete();

        return redirect(route('document-folders.index', ['document_folder_id' => $folderId]))
        ->with('success', 'File deleted successfully.');
    }
}
