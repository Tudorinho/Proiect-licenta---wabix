@extends('layouts.master')

@section('title')
    @lang('translation.taskStatusChange.addTaskStatusChange')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('tasks-statuses-changes.index') }}">@lang('translation.taskStatusChange.tasksStatusesChanges')</a>
        @endslot
        @slot('title')
            @lang('translation.taskStatusChange.addTaskStatusChange')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            @if($errors->any())
               <div class="col-12 alert alert-danger">
                   {!! implode('', $errors->all('<div>:message</div>')) !!}
               </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tasks-statuses-changes.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.userId')</label>
                                <select class="form-control" name="user_id" id="user_id_dropdown">
                                    @foreach($users as $value)
                                        <option value="{{ $value->id }}" {{ (old('user_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->email }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#user_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.taskId')</label>
                                <select class="form-control" name="task_id" id="task_id_dropdown">
                                    @foreach($tasks as $value)
                                        <option value="{{ $value->id }}" {{ (old('task_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->title }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('task_id'))
                                    <div class="invalid-feedback">{{ $errors->first('task_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#task_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.fromStatus')</label>
                                <select class="form-control" name="from_status" id="from_status_dropdown">
                                    @foreach($from_statuses as $value)
                                        <option value="{{ $value }}" {{ (old('from_status') == $value || (isset($model) && $model->from_status == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('from_status'))
                                    <div class="invalid-feedback">{{ $errors->first('from_status') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#from_status_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.toStatus')</label>
                                <select class="form-control" name="to_status" id="to_status_dropdown">
                                    @foreach($to_statuses as $value)
                                        <option value="{{ $value }}" {{ (old('to_status') == $value || (isset($model) && $model->to_status == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('to_status'))
                                    <div class="invalid-feedback">{{ $errors->first('to_status') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#to_status_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
						</div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-md">@lang('translation.buttons.submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
