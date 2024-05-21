@extends('layouts.master')

@section('title')
    @lang('translation.task.myTasks')
@endsection

@section('css')
    <style>
        .select2-container{
            z-index: 99999;
            font-weight: normal;
            font-size: 14px;
        }

        .datepicker-dropdown{
            position: absolute !important;
            z-index: 999999 !important;
        }

        .accordion-item:last-of-type{
            border: 0px !important;
        }

        .accordion-button:not(.collapsed){
            background-color: #ffffff !important;
        }

        .tasks_table>:not(caption)>*>*{
            padding-bottom: 0px !important;
            padding-top: 0px !important;
            padding-left: 0px !important;
        }

        .tasks_table>:not(caption)>*>*:last-of-type{
            padding-right: 0px !important;
        }

        .accordion_task .accordion-button{
            padding-left: 0px !important;
            padding-right: 0px !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }

        .accordion-button-filters{
            padding-right: 25px !important;
        }

        .select2-container{
            width: 100% !important;
        }

        .message_wrapper{
            margin-bottom: 10px;
            border-bottom: 1px solid #cccccc;
        }

        .message_wrapper_last_message{
            background-color: #fcf8e3;
        }

        .labels span{
            margin-top: 6px;
        }

        .toggle_ce_fields_cb{
            position: relative;
            top: 2px;
            left: 10px;
        }

        .task_extra_details{
            font-size: 10px;
            font-weight: bold;
            color: #c3c3c3;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.task.myTasks')
        @endslot
    @endcomponent

    <div class="accordion" style="margin-bottom: 5px;">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <div class="accordion-button accordion-button-filters collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_filters">
                    <div class="col-12">Filters @if(!empty($activeFiltersCount)) ({{ $activeFiltersCount }} active filters) @endif</div>
                </div>
            </h2>
            @include('tasks.partials.filters')
        </div>
    </div>

    @foreach($tasksLists as $taskList)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <?php $totalTasks = $taskList->tasks->count(); ?>
                    <div style="float: left">{{ $taskList->name }}( Displaying {{ $totalTasks >= $filterTasksDisplayed ? $filterTasksDisplayed : $totalTasks }} of {{ $totalTasks }} tasks )</div>
                    <div style="float: right">
                        <button style="padding: 5px 7px 5px 7px; margin-top: -10px;" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#add_task_{{ $taskList->id }}">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div id="add_task_{{ $taskList->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Add Action for {{ $taskList->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tasks.quick-add', ['id'=> $taskList->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <input type="hidden" name="tasks_lists_id" value="{{ $taskList->id }}">

                                                <div class="col-12">
                                                    <label class="form-label">@lang('translation.fields.title')</label>
                                                    <input type="text" class="form-control" required="required" name="title" placeholder="@lang('translation.fields.title')">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="form-label">@lang('translation.fields.description')</label>
                                                    <textarea style="height: 180px; resize: none;" class="form-control" name="description" placeholder="@lang('translation.fields.description')"></textarea>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <label class="form-label">@lang('translation.fields.dueDate')</label>
                                                    <input required="required" type="text" class="form-control" id="due_date_datepicker_{{ $taskList->id }}" name="due_date" placeholder="@lang('translation.fields.dueDate')" value="{{ $today }}">
                                                    @if(!empty($errors->first('due_date')))
                                                        <div class="invalid-feedback">{{ $errors->first('due_date') }}</div>
                                                    @endif
                                                </div>
                                                @push('scripts')
                                                    <script>
                                                        $(function() {
                                                            $('#due_date_datepicker_{{ $taskList->id }}').datepicker({
                                                                "format": "yyyy-mm-dd"
                                                            });
                                                        });
                                                    </script>
                                                @endpush

                                                <div class="col-4 mt-3">
                                                    <label class="form-label">@lang('translation.fields.status')</label>
                                                    <select name="status" class="form-control" id="status_dropdown_{{ $taskList->id }}">
                                                        @foreach($statuses as $value)
                                                            <option value="{{ $value }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
{{--                                                    @push('scripts')--}}
{{--                                                        <script>--}}
{{--                                                            $(function() {--}}
{{--                                                                $('#status_dropdown_{{ $taskList->id }}').select2({--}}
{{--                                                                    placeholder: 'Select an option...'--}}
{{--                                                                });--}}
{{--                                                            });--}}
{{--                                                        </script>--}}
{{--                                                    @endpush--}}
                                                </div>

                                                <div class="col-4 mt-3">
                                                    <label class="form-label">@lang('translation.fields.priority')</label>
                                                    <select class="form-control" name="priority" id="priority_dropdown_{{ $taskList->id }}">
                                                        @foreach($priorities as $value)
                                                            <option value="{{ $value }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4 mt-3">
                                                    <label class="form-label">@lang('translation.fields.estimate')</label>
                                                    <input type="text" class="form-control" name="estimate" placeholder="@lang('translation.fields.estimate')" value="0">
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <label class="form-label">@lang('translation.fields.userId')</label>
                                                    <select class="form-control" name="user_id" id="user_id_dropdown_{{ $taskList->id }}">
                                                        @foreach($taskList->users as $value)
                                                            <option value="{{ $value->user->id }}" {{ Auth::user()->id == $value->user->id ? 'selected' : '' }}>{{ $value->user->email }}</option>
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

                        @include('tasks.partials.task-list-report', compact('taskList'))
                    </div>
                </h4>
                @include('tasks.partials.task-list-tasks', compact('taskList', 'users'))
            </div>
        </div>
    @endforeach
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.task_contact_information').click(function(){
                var taskId = $(this).attr('data-task-id');

                var data = {
                    'task_id': taskId,
                    "_token": "{{ csrf_token() }}"
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('tasks.contact-information') }}",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: data,
                    success:function(data){
                        $('#task_contact_information_modal_body_'+taskId).html(data);
                    }
                });
            });

            $('body').on('click', '.task_contact_information_submit', function(e){
                e.preventDefault();
                var thisBtn = $(this);
                var formData = $(this).parents('form').serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('tasks.contact-information-update') }}",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: formData,
                    success:function(data){
                        thisBtn.attr('disabled','disabled');

                        toastr.success(data);
                    }
                });
            });

            $('.task_list_report').click(function(){
                var tasksListsId = $(this).attr('data-tasks-lists-id');

                var data = {
                    'tasks_lists_id': tasksListsId,
                    "_token": "{{ csrf_token() }}"
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('tasks.tasks-lists-report') }}",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: data,
                    success:function(data){
                        $('#task_list_report_modal_body_'+tasksListsId).html(data);
                    }
                });
            });

            $('.task_thread_messages').click(function(){
                var taskId = $(this).attr('data-task-id');

                var data = {
                    'task_id': taskId,
                    "_token": "{{ csrf_token() }}"
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('tasks.thread-messages') }}",
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: data,
                    success:function(data){
                        $('#task_thread_messages_modal_body_'+taskId).html(data);
                    }
                });
            });
        });
    </script>
@endsection
