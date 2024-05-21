<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFolder extends Model
{
    protected $fillable = ['document_folder_id', 'name'];

    // Relatia parinte
    public function parent()
    {
        return $this->belongsTo(DocumentFolder::class, 'document_folder_id');
    }

    // Relatia copii
    public function children()
    {
        return $this->hasMany(DocumentFolder::class, 'document_folder_id');
    }

    // Relația cu DocumentFolderFiles
    public function files()
    {
        return $this->hasMany(DocumentFolderFile::class, 'document_folder_id');
    }

    public function getParentFoldersAttribute()
    {
        $parents = collect([]);
        $folder = $this;

        while ($folder) {
            $parents->prepend($folder);
            $folder = $folder->parent; // Assuming you have a 'parent' relationship defined
        }

        return $parents;
    }

    public function permissions()
    {
        return $this->hasMany(DocumentFolderPermission::class);
    }

    use HasFactory;
}
