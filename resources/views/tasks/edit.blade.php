@extends('layouts.master')

@section('title')
    @lang('translation.task.addTask')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('tasks.index') }}">@lang('translation.task.tasks')</a>
        @endslot
        @slot('title')
            @lang('translation.task.addTask')
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
                    <form action="{{ route('tasks.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-12 ">
                                <label class="form-label">@lang('translation.fields.title')</label>
                                <input type="text" class="form-control" name="title" placeholder="@lang('translation.fields.title')" value="{{ old('title', $model?->title ?? '') }}">
                                @if(!empty($errors->first('title')))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.description')</label>
                                <textarea class="form-control" name="description" placeholder="@lang('translation.fields.description')">{{ old('description', $model?->description ?? '') }}</textarea>
                                @if(!empty($errors->first('description')))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.status')</label>
                                <select class="form-control" name="status" id="status_dropdown">
                                    @foreach($statuses as $value)
                                        <option value="{{ $value }}" {{ (old('status') == $value || (isset($model) && $model->status == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('status'))
                                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#status_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.priority')</label>
                                <select class="form-control" name="priority" id="priority_dropdown">
                                    @foreach($priorities as $value)
                                        <option value="{{ $value }}" {{ (old('priority') == $value || (isset($model) && $model->priority == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('priority'))
                                    <div class="invalid-feedback">{{ $errors->first('priority') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#priority_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.dueDate')</label>
                                <input type="text" class="form-control" id="due_date_datepicker" name="due_date" placeholder="@lang('translation.fields.dueDate')" value="{{ old('due_date', $model?->due_date ?? '') }}">
                                @if(!empty($errors->first('due_date')))
                                    <div class="invalid-feedback">{{ $errors->first('due_date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#due_date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.userId')</label>
                                <select class="form-control" name="user_id" id="user_id_dropdown">
                                    @foreach($users as $value)
                                        <option value="{{ $value->id }}" {{ (old('user_id') == $value->id || (isset($model) && $model->user_id == $value->id)) ? 'selected' : '' }}>{{ $value->email }}</option>
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
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.tasksListsId')</label>
                                <select class="form-control" name="tasks_lists_id" id="tasks_lists_id_dropdown">
                                    @foreach($tasksLists as $value)
                                        <option value="{{ $value->id }}" {{ (old('tasks_lists_id') == $value->id || (isset($model) && $model->tasks_lists_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tasks_lists_id'))
                                    <div class="invalid-feedback">{{ $errors->first('tasks_lists_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#tasks_lists_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.estimate')</label>
                                <input type="text" class="form-control" name="estimate" placeholder="@lang('translation.fields.estimate')" value="{{ old('estimate', $model?->estimate ?? 0) }}">
                                @if(!empty($errors->first('estimate')))
                                    <div class="invalid-feedback">{{ $errors->first('estimate') }}</div>
                                @endif
                            </div>
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
