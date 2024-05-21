@extends('layouts.master')

@section('title')
    @lang('translation.employee.addEmployee')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .invalid-feedback{
            display: block !important;
        }
    </style>
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
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST">
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.first_name')</label>
                                <input type="text" class="form-control" name="first_name" placeholder="@lang('translation.fields.firstName')" value="{{ old('first_name', $model?->first_name ?? '') }}">
                                @if(!empty($errors->first('first_name')))
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.last_name')</label>
                                <input type="text" class="form-control" name="last_name" placeholder="@lang('translation.fields.lastName')" value="{{ old('last_name', $model?->last_name ?? '') }}">
                                @if(!empty($errors->first('last_name')))
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>
						</div>
						<h5 class="mt-3">@lang('translation.headings.financialInformation')</h5>

						<div class="row">
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
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(function() {
            function formatItem (state) {
                if (!state.id) {
                    return state.text;
                }
                let model = JSON.parse(state.element.value);

                var $state = $(
                    '<span style="display: inline-block; width: 22px; height: 22px; background-color: '+model.color+'"></span>' +
                    '<span style="position: relative; top: -6px; left: 10px;">' +
                    model.name +
                    '</span>'
                );
                return $state;
            };

            $('#project_status_dropdown').select2({
                placeholder: 'Select an option',
                templateResult: formatItem
            });

            $('#project_priority_dropdown').select2({
                placeholder: 'Select an option',
                templateResult: formatItem
            });

            $('#project_contract_type_dropdown').select2({
                placeholder: 'Select an option',
                templateResult: formatItem
            });
        });
    </script>
@endsection
