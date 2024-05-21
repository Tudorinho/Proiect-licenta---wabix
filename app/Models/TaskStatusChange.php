<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatusChange extends Model
{
    use HasFactory;

    protected $table = "tasks_statuses_changes";

	protected $fillable = [
		'task_id',
		'from_status',
		'to_status',
		'user_id',
	];

	public function task()
	{
		return $this->belongsTo(Task::class, 'task_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
