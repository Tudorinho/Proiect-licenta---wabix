<button style="padding: 5px 7px 5px 7px; margin-top: -10px;"
        class="btn btn-primary waves-effect waves-light task_list_report"
        data-bs-toggle="modal"
        data-tasks-lists-id="{{ $taskList->id }}"
        data-bs-target="#report_{{ $taskList->id }}">
    <i class="fas fa-chart-bar"></i>
</button>
<div id="report_{{ $taskList->id }}" class="modal modal-xl" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Reports for {{ $taskList->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="task_list_report_modal_body_{{ $taskList->id }}">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
