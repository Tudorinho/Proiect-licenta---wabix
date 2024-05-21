<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiCategory extends Model
{
    use HasFactory;

    protected $table = "wiki_categories";

	protected $fillable = [
		'name',
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

    public function getArticlesCount()
    {
        return WikiArticle::where([
            'wiki_categories_id' => $this->id
        ])->count();
    }

}
