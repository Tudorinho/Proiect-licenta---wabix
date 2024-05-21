<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";

    protected $fillable = [
        "name",
        "project_status_id",
        "project_priority_id",
        "project_contract_type_id",
        "project_source_id",
        "currency_id",
        "flat_estimated_value",
        "flat_negotiated_value",
        "flat_accepted_value",
        "color",
    ];

    public function projectSource()
    {
        return $this->belongsTo(ProjectSource::class, 'project_source_id', 'id');
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id', 'id');
    }

    public function projectPriority()
    {
        return $this->belongsTo(ProjectPriority::class, 'project_priority_id', 'id');
    }

    public function projectContractType()
    {
        return $this->belongsTo(ProjectContractType::class, 'project_contract_type_id', 'id');
    }

    public function projectActions()
    {
        return $this->hasMany(ProjectAction::class, 'project_id', 'id');
    }

    public function getDocuments()
    {
        return Document::where([
            'entity_id' => $this->id,
            'entity_type' => "project"
        ])->orderBy('created_at', 'desc')->get();
    }
}
