<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{
    use HasFactory;

    protected $table = 'human_resources';

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
    ];

    public function details()
    {
        return $this->hasMany(HumanResourceDetails::class);
    }

    public function academicDetails()
    {
        return $this->hasMany(HumanResourceDetails::class)->where('is_academic', true);
    }

    public function professionalDetails()
    {
        return $this->hasMany(HumanResourceDetails::class)->where('is_academic', false);
    }

}
