<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAction extends Model
{
    use HasFactory;

    protected $table = "projects_actions";

    protected $fillable = [
        "description",
        "status",
        "due_date",
        "project_id"
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
