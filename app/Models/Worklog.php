<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worklog extends Model
{
    use HasFactory;

    protected $table = "worklogs";

	protected $fillable = [
		'hours',
		'employee_id',
		'project_id',
        'description',
        'date'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id', 'id');
	}

	public function project()
	{
		return $this->belongsTo(Project::class, 'project_id', 'id');
	}
}
