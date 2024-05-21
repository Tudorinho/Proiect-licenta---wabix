<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = "leaves";

	protected $fillable = [
		'employee_id',
		'leaves_types_id',
		'status',
		'start_date',
		'end_date',
		'leave_days',
        'holiday_days',
		'weekend_days',
        'year'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id', 'id');
	}

	public function leaveType()
	{
		return $this->belongsTo(LeaveType::class, 'leaves_types_id', 'id');
	}

    public static function getData($startDate, $endDate)
    {
        $startDate = new Carbon($startDate);
        $startDateYear = $startDate->year;
        $endDate = new Carbon($endDate);
        $endDateYear = $endDate->year;

        $holidaysData = [];
        $holidays = Holiday::whereYear('start_date', $startDateYear)->get();
        foreach($holidays as $holiday){
            $start = new Carbon($holiday->start_date);
            $end = new Carbon($holiday->end_date);
            while($end >= $start){
                $holidaysData[] = new Carbon($start);
                $start = $start->addDay();
            }
        }

        $leaveDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($holidaysData) {
            return $date->isWeekday() && !in_array($date, $holidaysData);
        }, $endDate) + 1;
        $weekendDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($holidaysData) {
            return !$date->isWeekday();
        }, $endDate);
        $holidayDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($holidaysData) {
            return in_array($date, $holidaysData);
        }, $endDate);
        $totalDays = $startDate->diffInDays($endDate);

        $now = new Carbon();
        $daysBeforeLeave = $now->diffInDays($startDate);

        return [
            $startDate,
            $endDate,
            $startDateYear,
            $endDateYear,
            $leaveDays,
            $weekendDays,
            $holidayDays,
            $totalDays,
            $daysBeforeLeave
        ];
    }
}
