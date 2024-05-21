<div id="collapse_filters" class="accordion-collapse collapse">
    <div class="accordion-body">
        <div class="text-muted">
            <form action="{{ route('tasks.list') }}">
                <div class="row">
                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.taskTitle')</label>
                        <input type="text" class="form-control" name="filter_task_title" placeholder="@lang('translation.fields.taskTitle')" value="{{ $filterTaskTitle }}">
                    </div>

                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.startDueDate')</label>
                        <input type="text" class="form-control" name="filter_start_due_date" id="filter_start_due_date_dropdown" placeholder="@lang('translation.fields.startDueDate')" value="{{ $filterStartDueDate }}">
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_start_due_date_dropdown').datepicker({
                                    "format": "yyyy-mm-dd"
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.endDueDate')</label>
                        <input type="text" class="form-control" name="filter_end_due_date" id="filter_end_due_date_dropdown" placeholder="@lang('translation.fields.endDueDate')" value="{{ $filterEndDueDate }}">
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_end_due_date_dropdown').datepicker({
                                    "format": "yyyy-mm-dd"
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <label class="form-label" style="display: block;">@lang('translation.fields.status')</label>
                        <select class="form-control" name="filter_status[]" id="filter_status_dropdown" multiple="multiple"><br>
                            @foreach($statuses as $value)
                                <option value="{{ $value }}" {{ in_array($value, $filterStatus) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_status_dropdown').select2({
                                    placeholder: 'Select an option...'
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <label class="form-label" style="display: block;">@lang('translation.fields.priority')</label>
                        <select class="form-control" name="filter_priority[]" id="filter_priority_dropdown" multiple="multiple"><br>
                            @foreach($priorities as $value)
                                <option value="{{ $value }}" {{ in_array($value, $filterPriority) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_priority_dropdown').select2({
                                    placeholder: 'Select an option...'
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <label class="form-label" style="display: block">@lang('translation.fields.searchReset')</label>

                        <input type="hidden" value="true" name="filter_change_filters">
                        <button type="submit" class="btn btn-primary" style="margin-top: -2px;">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('tasks.list').'?filter_reset=true' }}" class="btn btn-danger" style="margin-top: -2px;">
                            <i class="fas fa-circle-notch"></i>
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.userId')</label>
                        <select class="form-control" name="filter_user[]" id="filter_user_dropdown" multiple="multiple">
                            @foreach($users as $value)
                                <option value="{{ $value->id }}" {{ in_array($value->id, $filterUser) ? 'selected' : '' }}>{{ $value->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_user_dropdown').select2({
                                    placeholder: 'Select an option'
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.tasksListsId')</label>
                        <select class="form-control" name="filter_task_list[]" id="filter_task_list_dropdown" multiple="multiple">
                            @foreach($tasksLists as $value)
                                <option value="{{ $value->id }}" {{ in_array($value->id, $filterTaskList) ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_task_list_dropdown').select2({
                                    placeholder: 'Select an option'
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.bringDoneAlso')</label>
                        <br>
                        <input type="checkbox" class="fl" name="filter_bring_done" id="filter_bring_done" @checked(!empty($filterBringDoneAlso))>
                    </div>
                    <div class="col-2">
                        <label class="form-label">@lang('translation.fields.tasksDisplayedPerList')</label>
                        <select class="form-control" name="filter_tasks_displayed" id="filter_tasks_displayed_dropdown">
                            <option value="10" {{ $filterTasksDisplayed == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $filterTasksDisplayed == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $filterTasksDisplayed == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#filter_tasks_displayed_dropdown').select2({
                                    placeholder: 'Select an option'
                                });
                            });
                        </script>
                    @endpush
                </div>
            </form>
        </div>
    </div>
</div>
