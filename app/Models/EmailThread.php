<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailThread extends Model
{
    use HasFactory;

    protected $table = "emails_threads";

	protected $fillable = [
		'identifier',
		'companies_contacts_id',
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

	public function companyContact()
	{
		return $this->belongsTo(CompanyContact::class, 'companies_contacts_id', 'id');
	}

    public function emailThreadMessages()
    {
        return $this->hasMany(EmailThreadMessage::class, 'emails_threads_id', 'id')->orderBy('date', 'desc');
    }
}
