<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $table = "deals";

	protected $fillable = [
		'user_id',
		'companies_contacts_id',
		'emails_threads_id',
		'deals_statuses_id',
		'deals_sources_id',
		'currency_id',
		'deal_size',
		'type',
		'title',
		'description',
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

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function companyContact()
	{
		return $this->belongsTo(CompanyContact::class, 'companies_contacts_id', 'id');
	}

	public function emailThread()
	{
		return $this->belongsTo(EmailThread::class, 'emails_threads_id', 'id');
	}

	public function dealStatus()
	{
		return $this->belongsTo(DealStatus::class, 'deals_statuses_id', 'id');
	}

	public function dealSource()
	{
		return $this->belongsTo(DealSource::class, 'deals_sources_id', 'id');
	}

	public function currency()
	{
		return $this->belongsTo(Currency::class, 'currency_id', 'id');
	}

    public function dealNotes()
    {
        return $this->hasMany(DealNote::class, 'deals_id', 'id');
    }
}
