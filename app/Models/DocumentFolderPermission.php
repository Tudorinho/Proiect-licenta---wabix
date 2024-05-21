<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFolderPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_folder_id',
        'user_id',
    ];

    public function documentFolder()
    {
        return $this->belongsTo(DocumentFolder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
