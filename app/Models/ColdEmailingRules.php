<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColdEmailingRules extends Model
{
    use HasFactory;

    protected $table = "cold_emailing_rules";

	protected $fillable = [
		'name',
		'cold_emailing_credentials_id',
		'subject',
		'since',
		'before',
		'last_check_date',
		'user_id',
		'tasks_lists_id',
        'last_error'
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

	public function coldEmailingCredential()
	{
		return $this->belongsTo(ColdEmailingCredentials::class, 'cold_emailing_credentials_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function taskList()
	{
		return $this->belongsTo(TaskList::class, 'tasks_lists_id', 'id');
	}
}
