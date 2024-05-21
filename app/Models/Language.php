<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name'];

    // Relația cu DocumentFolderFile
    public function files()
    {
        return $this->hasMany(DocumentFolderFile::class, 'language_id');
    }

    use HasFactory;
}
