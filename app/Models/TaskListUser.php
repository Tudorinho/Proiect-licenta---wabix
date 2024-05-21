<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskListUser extends Model
{
    use HasFactory;

    protected $table = "tasks_lists_users";

	protected $fillable = [
		'user_id',
		'tasks_lists_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function taskList()
	{
		return $this->belongsTo(TaskList::class, 'tasks_lists_id', 'id');
	}
}
