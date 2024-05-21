<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";

	protected $fillable = [
		'title',
		'description',
		'status',
		'priority',
		'due_date',
		'user_id',
		'tasks_lists_id',
        'created_by_uyser_id',
        'type',
        'emails_threads_id',
        'companies_contact_id',
        'email_thread_message_identifier',
        'auto_responder_type',
        'emails_threads_messages_id',
        'cold_calling_status',
        'cold_calling_lists_contacts_id',
        'estimate',
	];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->created_by_user_id = Auth::user() ? Auth::user()->id : null;
        });

        self::created(function($model){
            $currentUser = Auth::user();
            if (!empty($currentUser)){
                $userId = $currentUser->id;
                Cache::delete('dashboard_tasks_'.$userId);
                Cache::delete('header_tasks_'.$userId);
            } else{
                $userId = null;
            }

            TaskStatusChange::create([
                'task_id' => $model->id,
                'user_id' => $userId,
                'from_status' => '',
                'to_status' => !empty($model->status) ? $model->status : 'pending'
            ]);
        });

        self::updating(function($model){
            if($model->original['status'] != $model->status){
                TaskStatusChange::create([
                    'task_id' => $model->id,
                    'user_id' => Auth::user() ? Auth::user()->id : null,
                    'from_status' => $model->original['status'],
                    'to_status' => !empty($model->status) ? $model->status : 'pending'
                ]);
            }
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

	public function taskList()
	{
		return $this->belongsTo(TaskList::class, 'tasks_lists_id', 'id');
	}

    public function emailThread()
    {
        return $this->belongsTo(EmailThread::class, 'emails_threads_id', 'id');
    }

    public function emailThreadMessage()
    {
        return $this->belongsTo(EmailThreadMessage::class, 'emails_threads_messages_id', 'id');
    }

    public function companyContact()
    {
        return $this->belongsTo(CompanyContact::class, 'companies_contact_id', 'id');
    }

    public function getDueDate()
    {
        $dueDate = new Carbon($this->due_date);
        return $dueDate->format('Y-m-d');
    }

    public function getDaysLeft()
    {
        if ($this->status == 'done'){
            $taskStatusChange = TaskStatusChange::where([
                'task_id' => $this->id,
                'to_status' => 'done'
            ])->orderBy('created_at', 'desc')->first();
            if (empty($taskStatusChange)){
                $dueDate = new Carbon($this->due_date);
            } else{
                $dueDate = new Carbon($taskStatusChange->created_at);
            }

        } else{
            $dueDate = new Carbon($this->due_date);
        }
        $dueDate->setTime(23,59,59);

        $now = new Carbon();
        $now->setTime(23,59,59);

        $daysDiff = $now->diffInDays($dueDate);

        if ($daysDiff == 0){
            return '<span class="badge rounded-pill badge-soft-warning font-size-11">'.$daysDiff.'</span>';
        } elseif($dueDate < $now){
            return '<span class="badge rounded-pill badge-soft-danger font-size-11">-'.$daysDiff.'</span>';
        } else{
            return '<span class="badge rounded-pill badge-soft-success font-size-11">'.$daysDiff.'</span>';
        }
    }
}
