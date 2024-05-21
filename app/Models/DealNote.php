<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealNote extends Model
{
    use HasFactory;

    protected $table = "deals_notes";

	protected $fillable = [
		'deals_id',
		'note',
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

	public function deal()
	{
		return $this->belongsTo(Deal::class, 'deals_id', 'id');
	}
}
