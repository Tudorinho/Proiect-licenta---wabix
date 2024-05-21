<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = "documents";

    protected $fillable = [
        'entity_id',
        'entity_type',
        'type',
        'name',
        'data'
    ];
}
