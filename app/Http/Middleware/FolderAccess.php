<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DocumentFolderPermission;

class FolderAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next)
    {
        // If the user is admin, there is no check required
        if(auth()->user()->role == "admin"){
            return $next($request);
        }

        // Verify if there is document_folder_id in request
        if ($request->filled('document_folder_id')) {
            $folderId = $request->input('document_folder_id');
            $user = auth()->user();

            // Look for perimissions in the specified folder
            $permissions = DocumentFolderPermission::where('document_folder_id', $folderId)->pluck('user_id');

            // Verify if the user has permissions
            if ($permissions->isEmpty() || $permissions->contains($user->id)) {
                return $next($request);
            } else {
                abort(403, 'Unauthorized action.');
            }
        }

        // If there is no document_folder_id(so no permissions in the database), allow the user to view the file
        return $next($request);
    }
}
