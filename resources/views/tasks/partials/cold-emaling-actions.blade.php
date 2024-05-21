<button style="float: left; margin: 2px;" class="edit btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#task_cold_emailing_actions{{ $task->id }}">
    <i class="fas fa-envelope-open-text"></i>
</button>
<div id="task_cold_emailing_actions{{ $task->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Cold Emailing Actions {{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">@lang('translation.fields.quickActions')</label>

                <div class="row">
                    <div class="col-6">
                        <form action="{{ route('tasks.cold-emailing-quick-actions', ['id' => $task->id]) }}" method="POST">
                            <div>
                                {{ csrf_field() }}
                                <input type="hidden" name="auto_responder_type" value="failed">
                                <button style="width: 100%;" type="submit" class="btn btn-danger w-md">@lang('translation.buttons.failedAndComplete')</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-6">
                        <form action="{{ route('tasks.cold-emailing-quick-actions', ['id' => $task->id]) }}" method="POST">
                            <div>
                                {{ csrf_field() }}
                                <input type="hidden" name="auto_responder_type" value="maternity">
                                <button style="width: 100%;" type="submit" class="btn btn-warning w-md">@lang('translation.buttons.maternityAndComplete')</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-6 mt-3">
                        <form action="{{ route('tasks.cold-emailing-quick-actions', ['id' => $task->id]) }}" method="POST">
                            <div>
                                {{ csrf_field() }}
                                <input type="hidden" name="auto_responder_type" value="out_of_office">
                                <button style="width: 100%;" type="submit" class="btn btn-primary w-md">@lang('translation.buttons.oooAndComplete')</button>
                            </div>
                        </form>
                    </div>
                </div>


                <form action="{{ route('tasks.cold-emailing-actions', ['id' => $task->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-12 mt-3">
                        <label class="form-label">@lang('translation.fields.autoResponderType')</label>
                        <select class="form-control" name="auto_responder_type" id="auto_responder_type_dropdown_{{ $task->id }}">
                            @foreach($autoResponderTypes as $value)
                                <option value="{{ $value }}" {{ $value == $task->auto_responder_type ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="form-label">@lang('translation.fields.createNewTaskAndMarkCurrentAsCompleted')</label>
                        <input class="toggle_ce_fields_cb" type="checkbox" id="create_new_task_{{ $task->id }}" name="create_new_task" value="1">
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#create_new_task_{{ $task->id }}').click(function (){
                                    $('#hidden_fields_{{ $task->id }}').toggle();
                                });
                            });
                        </script>
                    @endpush
                    <div id="hidden_fields_{{ $task->id }}" style="display: none;">
                        <div class="col-12">
                            <label class="form-label">@lang('translation.fields.userId')</label>
                            <select class="form-control" name="user_id">
                                @foreach($users as $value)
                                    <option value="{{ $value->id }}">{{ $value->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label">@lang('translation.fields.dueDate')</label>
                            <input required="required" type="text" class="form-control" id="due_date_datepicker_task_ce_{{ $task->id }}" name="due_date" placeholder="@lang('translation.fields.dueDate')" value="{{ $today }}">
                        </div>
                        @push('scripts')
                            <script>
                                $(function() {
                                    $('#due_date_datepicker_task_ce_{{ $task->id }}').datepicker({
                                        "format": "yyyy-mm-dd"
                                    });
                                });
                            </script>
                        @endpush

                        <div class="col-12 mt-3">
                            <label class="form-label">@lang('translation.fields.description')</label>
                            <textarea style="height: 180px; resize: none;" class="form-control" name="description" placeholder="@lang('translation.fields.description')"></textarea>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary w-md">@lang('translation.buttons.submit')</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
