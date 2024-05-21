<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = "employees";

	protected $fillable = [
		'first_name',
		'last_name',
		'gender',
		'date_of_birth',
		'email',
		'user_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
