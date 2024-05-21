<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiArticle extends Model
{
    use HasFactory;

    protected $table = "wiki_articles";

	protected $fillable = [
		'title',
		'body',
		'wiki_categories_id',
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

	public function wikiCategory()
	{
		return $this->belongsTo(WikiCategory::class, 'wiki_categories_id', 'id');
	}
}
