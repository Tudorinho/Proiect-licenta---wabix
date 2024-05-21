<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResourceProject extends Model
{
    protected $fillable = ['human_resource_detail_id', 'name', 'description', 'technologies'];

    public function humanResourceDetail()
    {
        return $this->belongsTo(HumanResourceDetails::class);
    }
    use HasFactory;
}
