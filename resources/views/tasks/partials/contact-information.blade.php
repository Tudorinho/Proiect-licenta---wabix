<button style="float: left; margin: 2px;"
        class="edit btn btn-danger btn-sm task_contact_information" data-bs-toggle="modal"
        data-task-id="{{ $task->id }}"
        data-bs-target="#task_contact_information_{{ $task->id }}">
    <i class="fas fa-user-alt"></i>
</button>
<div id="task_contact_information_{{ $task->id }}" class="modal modal-xl fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Task Contact Information - {{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="task_contact_information_modal_body_{{ $task->id }}" style="max-height: 300px;overflow-y: scroll;">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
