<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    use HasFactory;

    protected $table = "tasks_lists";

	protected $fillable = [
		'name',
	];

	public function tasks()
	{
		return $this->hasMany(Task::class, 'tasks_lists_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(TaskListUser::class, 'tasks_lists_id', 'id');
    }
}
