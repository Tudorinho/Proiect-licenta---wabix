<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContractType extends Model
{
    use HasFactory;

    protected $table = "projects_contracts_types";

    protected $fillable = [
        "name",
        "color"
    ];
}
