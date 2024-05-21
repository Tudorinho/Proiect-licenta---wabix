<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColdCallingList extends Model
{
    use HasFactory;

    protected $table = "cold_calling_lists";

	protected $fillable = [
		'name',
		'tasks_lists_id',
	];

    public static function boot(){
        parent::boot();

        self::creating(function($model){
            // ... code here
        });

        self::created(function($model){
            // ... code here
        });

        self::updating(function($model){
               // ... code here
        });

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
    }

	public function taskList()
	{
		return $this->belongsTo(TaskList::class, 'tasks_lists_id', 'id');
	}
}
