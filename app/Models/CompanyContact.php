<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    use HasFactory;

    protected $table = "companies_contacts";

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'position',
		'company_id',
		'phone'
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

	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id', 'id');
	}

    public function getFormattedName()
    {
        return $this->first_name.' '.$this->last_name.'('.$this->company->name.')';
    }
}
