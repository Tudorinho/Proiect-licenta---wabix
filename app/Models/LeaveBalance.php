<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $table = "leaves_balances";

	protected $fillable = [
		'employee_id',
		'leaves_types_id',
		'balance',
		'year',
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id', 'id');
	}

	public function leaveType()
	{
		return $this->belongsTo(LeaveType::class, 'leaves_types_id', 'id');
	}
}
