<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResourceDetails extends Model
{
    use HasFactory;

    protected $table = 'human_resource_details';

    protected $fillable = [
        'human_resource_id',
        'name',
        'start',
        'end',
        'type',
        'is_academic',
    ];

    public function humanResource()
    {
        return $this->belongsTo(HumanResource::class);
    }

    public function projects()
    {
        return $this->hasMany(HumanResourceProject::class, 'human_resource_detail_id');
    }
}
