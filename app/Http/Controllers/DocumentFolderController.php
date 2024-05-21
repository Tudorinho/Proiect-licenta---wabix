<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\DocumentFolder;
use App\Models\Employee;
use App\Models\DocumentFolderFile;



class DocumentFolderController extends Controller
{
    public function index(Request $request)
    {
        $folders = DocumentFolder::where('document_folder_id', $request->document_folder_id)
            ->orderBy('name')
            ->get();

        $files = DocumentFolderFile::where('document_folder_id', $request->document_folder_id)
            ->orderBy('name')
            ->paginate(20);

        $currentFolder = null;
        $breadcrumbs = collect([]);

        if ($request->has('document_folder_id')) {
                $currentFolder = DocumentFolder::with('parent')->find($request->document_folder_id);
                $breadcrumbs = $currentFolder->parent_folders;
            }

        $isAdmin = auth()->user()->role == "admin";

        return view('document-folders.index', compact('folders', 'files', 'breadcrumbs', 'currentFolder', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('document-folders.create'))->withInput()->withErrors($validator->errors());
        }

        $folder = DocumentFolder::create($request->all());

        // Actualizare permisiuni
        $folder->permissions()->delete(); // Șterge toate permisiunile existente

        if ($request->has('user_permissions')) {
            foreach ($request->user_permissions as $userId) {
                $folder->permissions()->create(['user_id' => $userId]);
            }
        }

        return redirect(route('document-folders.index', ['document_folder_id' => $request->document_folder_id]))
        ->with('success', 'Document folder created successfully.');
    }

    public function create()
    {
        $employees = Employee::all();
        return view('document-folders.create', compact('employees'));
    }

    public function edit($id)
    {
        $folder = DocumentFolder::find($id);
        $employees = Employee::all();
        return view('document-folders.edit', compact('folder', 'employees'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        $folder = DocumentFolder::find($id);

        if ($validator->fails()) {
            return redirect(route('document-folders.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        $folder->update($request->all());

        // Actualizare permisiuni
        $folder->permissions()->delete(); // Șterge toate permisiunile existente

        if ($request->has('user_permissions')) {
            foreach ($request->user_permissions as $userId) {
                $folder->permissions()->create(['user_id' => $userId]);
            }
        }

        return redirect(route('document-folders.index', ['document_folder_id' => $folder->document_folder_id]))
        ->with('success', 'Folder updated successfully.');
    }

    public function getChildren($id)
    {
        $children = DocumentFolder::where('document_folder_id', $id)->get();
        return response()->json($children);
    }

    public function destroy($id)
    {
        $folder = DocumentFolder::find($id);
        if (!$folder) {
            return redirect(route('document-folders.index'))->with('error', 'Document folder not found.');
        }

        $parentFolderId = $folder->document_folder_id;
        $folder->delete();

        return redirect(route('document-folders.index', ['document_folder_id' => $parentFolderId]))
        ->with('success', 'Document folder deleted successfully.');
    }


}
