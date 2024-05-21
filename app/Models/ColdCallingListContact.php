<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ColdCallingListContact extends Model
{
    use HasFactory;

    protected $table = "cold_calling_lists_contacts";

	protected $fillable = [
		'cold_calling_lists_id',
		'companies_contacts_id',
	];

    public static function boot(){
        parent::boot();

        self::creating(function($model){

        });

        self::created(function($model){
            $tasksListsUsersCount = DB::table('tasks')
                ->select('user_id', DB::raw('count(*) as cnt'))
                ->where([
                    'tasks_lists_id' => $model->coldCallingList->tasks_lists_id
                ])
                ->groupBy('user_id')
                ->get();

            $availableUsers = [];
            $tasksListsUsers = TaskListUser::where([
                'tasks_lists_id' => $model->coldCallingList->tasks_lists_id
            ])->get();
            foreach ($tasksListsUsers as $tasksListsUser){
                $availableUsers[$tasksListsUser->user_id] = 0;
            }
            if (!empty($tasksListsUsersCount)){
                foreach ($tasksListsUsersCount as $tasksListsUsersCnt){
                    $availableUsers[$tasksListsUsersCnt->user_id] = $tasksListsUsersCnt->cnt;
                }
            }

            asort($availableUsers, SORT_NUMERIC);
            $assignedUserId = array_keys($availableUsers)[0];

            $now = new Carbon();
            $now->addDays(5);

            if (!empty($model->companyContact->phone)){
                Task::firstOrCreate([
                    'title' => "Call contact ".$model->companyContact->first_name.' '.$model->companyContact->last_name.' ('.$model->companyContact->company->name.')',
                    'priority' => "high",
                    'status' => 'pending',
                    'due_date' => $now->format('Y-m-d'),
                    'user_id' => $assignedUserId,
                    'tasks_lists_id' => $model->coldCallingList->tasks_lists_id,
                    'type' => "cold_calling",
                    'companies_contact_id' => $model->companies_contacts_id,
                    'cold_calling_lists_contacts_id' => $model->id
                ]);
            }
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

	public function coldCallingList()
	{
		return $this->belongsTo(ColdCallingList::class, 'cold_calling_lists_id', 'id');
	}

	public function companyContact()
	{
		return $this->belongsTo(CompanyContact::class, 'companies_contacts_id', 'id');
	}
}
