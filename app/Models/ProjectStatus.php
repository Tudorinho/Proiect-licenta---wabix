<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    use HasFactory;

    protected $table = "projects_statuses";

    protected $fillable = [
        "name",
        "color",
        "is_ongoing"
    ];
}
