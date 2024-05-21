@extends('layouts.master')

@section('title')
    @lang('translation.worklog.addWorklog')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('worklogs.index') }}">@lang('translation.worklog.worklogs')</a>
        @endslot
        @slot('title')
            @lang('translation.worklog.addWorklog')
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
                    <form action="{{ route('worklogs.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.hours')</label>
                                <input type="text" class="form-control" name="hours" placeholder="@lang('translation.fields.hours')" value="{{ old('hours', $model?->hours ?? '') }}">
                                @if(!empty($errors->first('hours')))
                                    <div class="invalid-feedback">{{ $errors->first('hours') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.employeeId')</label>
                                <select class="form-control" name="employee_id" id="employee_id_dropdown">
                                    @foreach($employees as $value)
                                        <option value="{{ $value->id }}" {{ (old('employee_id') == $value->id || \Illuminate\Support\Facades\Auth::user()->employee->id == $value->id) ? 'selected' : '' }}>{{ $value->first_name.' '.$value->last_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee_id'))
                                    <div class="invalid-feedback">{{ $errors->first('employee_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#employee_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.projectId')</label>
                                <select class="form-control" name="project_id" id="project_id_dropdown">
                                    <option value="">Select project...</option>
                                    @foreach($projects as $value)
                                        <option value="{{ $value->id }}" {{ (old('project_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('project_id'))
                                    <div class="invalid-feedback">{{ $errors->first('project_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#project_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.date')</label>
                                <input type="text" class="form-control" id="date_datepicker" name="date" placeholder="@lang('translation.fields.date')" value="{{ old('date', $model?->date ?? $today) }}">
                                @if(!empty($errors->first('date')))
                                    <div class="invalid-feedback">{{ $errors->first('date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.description')</label>
                                <textarea style="resize: none; height: 250px;" class="form-control" name="description">{{ old('description', $model?->description ?? '') }}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">{{ $errors->first('description') }}</div>
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
