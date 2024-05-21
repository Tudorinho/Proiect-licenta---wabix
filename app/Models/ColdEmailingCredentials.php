<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColdEmailingCredentials extends Model
{
    use HasFactory;

    protected $table = "cold_emailing_credentials";

	protected $fillable = [
		'email',
		'username',
		'password',
		'validated',
		'last_error',
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

    public static function testConnection($username, $password)
    {
        $sentConnectionString = '{imap.gmail.com:993/imap/ssl/novalidate-cert}[Gmail]/Sent Mail';

        try{
            $connection = \imap_open($sentConnectionString, $username, $password, OP_SILENT);
        } catch(\Exception|\Error $e){
            return imap_last_error();
        }

        return '';
    }
}
