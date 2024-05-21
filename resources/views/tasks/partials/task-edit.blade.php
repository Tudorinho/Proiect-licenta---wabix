<button style="float: left; margin: 2px;" class="edit btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit_task_{{ $task->id }}">
    <i class="fas fa-pencil-alt"></i>
</button>
<div id="edit_task_{{ $task->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit {{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tasks.quick-edit', ['id'=> $task->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">@lang('translation.fields.title')</label>
                            <input type="text" class="form-control" name="title" placeholder="@lang('translation.fields.title')" value="{{ $task->title }}">
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label">@lang('translation.fields.description')</label>
                            <textarea style="height: 180px; resize: none;" class="form-control" name="description" placeholder="@lang('translation.fields.description')">{{ $task->description }}</textarea>
                        </div>

                        <div class="col-4 mt-3">
                            <label class="form-label">@lang('translation.fields.status')</label>
                            @if($task->status == 'done')
                                <select class="form-control" name="status" id="status_dropdown_{{ $task->id }}">
                                    <option value="done">Done</option>
                                </select>
                            @else
                                <select class="form-control" name="status" id="status_dropdown_{{ $task->id }}">
                                    @foreach($statuses as $value)
                                        <option value="{{ $value }}" {{ $task->status == $value ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="col-4 mt-3">
                            <label class="form-label">@lang('translation.fields.priority')</label>
                            <select class="form-control" name="priority" id="priority_dropdown_{{ $task->id }}">
                                @foreach($priorities as $value)
                                    <option value="{{ $value }}" {{ $task->priority == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @push('scripts')
                            <script>
                                $(function() {
                                    $('#priority_dropdown_{{ $task->id }}').select2({
                                        placeholder: 'Select an option',
                                        dropdownParent: $("#edit_task_{{ $task->id }}")
                                    });
                                });
                            </script>
                        @endpush
                        <div class="col-4 mt-3">
                            <label class="form-label">@lang('translation.fields.estimate')</label>
                            <input type="text" class="form-control" name="estimate" placeholder="@lang('translation.fields.estimate')" value="{{ floatval($task->estimate) }}">
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label">@lang('translation.fields.userId')</label>
                            <select class="form-control" name="user_id" id="user_id_dropdown_{{ $task->id }}">
                                @foreach($task->taskList->users as $value)
                                    <option value="{{ $value->user->id }}" {{ $task->user_id == $value->user->id ? 'selected' : '' }}>{{ $value->user->email }}</option>
                                @endforeach
                            </select>
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
