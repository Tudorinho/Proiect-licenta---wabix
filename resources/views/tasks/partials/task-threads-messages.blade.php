<button style="float: left; margin: 2px;" class="edit btn btn-dark btn-sm task_thread_messages"
        data-bs-toggle="modal"
        data-task-id="{{ $task->id }}"
        data-bs-target="#task_thread_messages_{{ $task->id }}">
    <i class="fas fa-people-arrows"></i>
</button>
<div id="task_thread_messages_{{ $task->id }}" class="modal modal-xl fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Thread Messages {{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 300px;overflow-y: scroll;"  id="task_thread_messages_modal_body_{{ $task->id }}">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
