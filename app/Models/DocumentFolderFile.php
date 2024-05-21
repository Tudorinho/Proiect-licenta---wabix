<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFolderFile extends Model
{
    use HasFactory;

    protected $fillable = ['document_folder_id', 'language_id', 'name', 'data', 'type'];

    // Relația înapoi către DocumentFolder
    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'document_folder_id');
    }

    // Relația înapoi către Language
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
