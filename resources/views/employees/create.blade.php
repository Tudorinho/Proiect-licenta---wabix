@extends('layouts.master')

@section('title')
    @lang('translation.employee.addEmployee')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('employees.index') }}">@lang('translation.employee.employees')</a>
        @endslot
        @slot('title')
            @lang('translation.employee.addEmployee')
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
                    <form action="{{ route('employees.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.firstName')</label>
                                <input type="text" class="form-control" name="first_name" placeholder="@lang('translation.fields.firstName')" value="{{ old('first_name', $model?->first_name ?? '') }}">
                                @if(!empty($errors->first('first_name')))
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.lastName')</label>
                                <input type="text" class="form-control" name="last_name" placeholder="@lang('translation.fields.lastName')" value="{{ old('last_name', $model?->last_name ?? '') }}">
                                @if(!empty($errors->first('last_name')))
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.gender')</label>
                                <select class="form-control" name="gender" id="gender_dropdown">
                                    @foreach($genders as $value)
                                        <option value="{{ $value }}" {{ (old('gender') == $value || (isset($model) && $model->gender == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('gender'))
                                    <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#gender_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.dateOfBirth')</label>
                                <input type="text" class="form-control" id="date_of_birth_datepicker" name="date_of_birth" placeholder="@lang('translation.fields.dateOfBirth')" value="{{ old('date_of_birth', $model?->date_of_birth ?? '') }}">
                                @if(!empty($errors->first('date_of_birth')))
                                    <div class="invalid-feedback">{{ $errors->first('date_of_birth') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#date_of_birth_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
						</div>
						<h5 class="mt-3">@lang('translation.headings.accountInformation')</h5>

						<div class="row">
                            <div class="col-3 #marginTop">
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
