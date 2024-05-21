<div class="table-responsive" style="width: 100% !important; max-height: 285px;overflow-y: scroll;">
    <table class="tasks_table table align-middle mb-0">
        <tbody>
            <tr style="padding-bottom: 10px;">
                <td class="pb-2 col-2">Status/Priority</td>
                <td class="pb-2 col-5">Title</td>
                <td class="pb-2 col-1">Assignee</td>
                <td class="pb-2 col-1">Due Date</td>
                <td class="pb-2 col-1">Days Left</td>
                <td class="pb-2 col-1">Estimate</td>
                <td class="pb-2 col-2">Actions</td>
            </tr>
            @foreach($taskList->tasks->take($filterTasksDisplayed) as $task)
                <tr>
                    <td class="col-md-2 labels">
                        @if($task->status != 'done')
                            <form style="float: left; margin-right: 7px;" method="POST" action="{{ route('tasks.mark-as-done', ['id' => $task->id]) }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif

                        @if($task->status == 'pending')
                            <span class="badge rounded-pill badge-soft-warning font-size-11">Pending</span>
                        @else
                            <span class="badge rounded-pill badge-soft-success font-size-11">Done</span>
                        @endif

                        @if($task->priority == 'low')
                            <span class="badge rounded-pill badge-soft-success font-size-11">Low</span>
                        @elseif($task->priority == 'medium')
                            <span class="badge rounded-pill badge-soft-warning font-size-11">Medium</span>
                        @else
                            <span class="badge rounded-pill badge-soft-danger font-size-11">High</span>
                        @endif

                        @if($task->auto_responder_type == 'failed')
                            <span class="badge rounded-pill badge-soft-danger font-size-11">Failed</span>
                        @elseif($task->auto_responder_type == 'maternity')
                            <span class="badge rounded-pill badge-soft-warning font-size-11">Maternity</span>
                        @elseif($task->auto_responder_type == 'out_of_office')
                            <span class="badge rounded-pill badge-soft-warning font-size-11">OOO</span>
                        @endif

                        @if($task->cold_calling_status == 'bad_phone_no')
                            <span class="badge rounded-pill badge-soft-danger font-size-11">Bad Phone No</span>
                        @elseif($task->cold_calling_status == 'not_interested')
                            <span class="badge rounded-pill badge-soft-warning font-size-11">Not Interested</span>
                        @elseif($task->cold_calling_status == 'interested')
                            <span class="badge rounded-pill badge-soft-success font-size-11">Interested</span>
                        @endif
                    </td>
                    <td class="col-md-5">
                        <div class="accordion accordion_task" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <div class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $task->id }}" aria-expanded="false" aria-controls="collapse_{{ $task->id }}">
                                        {{ $task->title }}
                                    </div>

                                    @if($task->type == 'cold_emailing')
                                        <div class="task_extra_details">Subject: {{ $task->emailThreadMessage->subject }}</div>
                                        <div class="task_extra_details">From: {{ $task->emailThreadMessage->from }}</div>
                                        <div class="task_extra_details">To: {{ $task->emailThreadMessage->to }}</div>
                                    @endif
                                </h2>
                                <div id="collapse_{{ $task->id }}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="text-muted">
                                            {{ $task->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="col-md-1">
                        <span>{{ $task->user->email }}</span>
                    </td>
                    <td class="col-md-1">
                        <h5 class="text-truncate font-size-14 m-0">{{ $task->getDueDate() }}</h5>
                    </td>
                    <td class="col-md-1">
                        <h5 class="text-truncate font-size-14 m-0">{!! $task->getDaysLeft() !!}</h5>
                    </td>
                    <td class="col-md-1">
                        <h5 class="text-truncate font-size-14 m-0">{{ floatval($task->estimate) }}</h5>
                    </td>
                    <td class="col-md-2">
                        @include('tasks.partials.task-edit', compact('task'))

                        @if($task->type == 'cold_emailing')
                            @include('tasks.partials.task-threads-messages', compact('task'))
                            @include('tasks.partials.cold-emaling-actions', compact('task', 'users'))
                            @include('tasks.partials.contact-information', compact('task'))
                            @if($task->status == 'pending')
                                @include('tasks.partials.create-deal', compact('task'))
                            @endif
                        @endif

                        @if($task->type == 'cold_calling')
                            @include('tasks.partials.cold-calling-actions', compact('task'))
                            @include('tasks.partials.contact-information', compact('task'))
                            @if($task->status == 'pending')
                                @include('tasks.partials.create-deal', compact('task'))
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
