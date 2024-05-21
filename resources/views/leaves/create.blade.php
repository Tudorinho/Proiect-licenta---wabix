@extends('layouts.master')

@section('title')
    @lang('translation.leave.addLeave')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('leaves.index') }}">@lang('translation.leave.leaves')</a>
        @endslot
        @slot('title')
            @lang('translation.leave.addLeave')
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
                    <form action="{{ route('leaves.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.employeeId')</label>
                                <select class="form-control" name="employee_id" id="employee_id_dropdown">
                                    @foreach($employees as $value)
                                        <option value="{{ $value->id }}" {{ (old('employee_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->first_name }}</option>
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
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.leavesTypesId')</label>
                                <select class="form-control" name="leaves_types_id" id="leaves_types_id_dropdown">
                                    @foreach($leavesTypes as $value)
                                        <option value="{{ $value->id }}" {{ (old('leaves_types_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('leaves_types_id'))
                                    <div class="invalid-feedback">{{ $errors->first('leaves_types_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#leaves_types_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
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
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.startDate')</label>
                                <input type="text" class="form-control" id="start_date_datepicker" name="start_date" placeholder="@lang('translation.fields.startDate')" value="{{ old('start_date', $model?->start_date ?? '') }}">
                                @if(!empty($errors->first('start_date')))
                                    <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#start_date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.endDate')</label>
                                <input type="text" class="form-control" id="end_date_datepicker" name="end_date" placeholder="@lang('translation.fields.endDate')" value="{{ old('end_date', $model?->end_date ?? '') }}">
                                @if(!empty($errors->first('end_date')))
                                    <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#end_date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
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
