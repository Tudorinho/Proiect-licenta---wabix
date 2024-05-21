@extends('layouts.master')

@section('title')
    @lang('translation.project.editProject')
@endsection

@section('css')
    <style>
        .invalid-feedback{
            display: block !important;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('projects.index') }}">@lang('translation.project.projects')</a>
        @endslot
        @slot('title')
            @lang('translation.project.editProject')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('projects.update', ['id' => $model->id]) }}" method="POST">
                        <h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>
                        @method('PUT')
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')" value="{{ old('name', $model->name) }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.status')</label>
                                <select class="form-control" name="project_status_id" id="project_status_dropdown">
                                    @foreach($projectStatuses as $projectStatus)
                                        <option data-value="{{ $projectStatus }}" value="{{ $projectStatus }}" @selected(old('project_status_id') ? old('project_status_id') == $projectStatus->id : $model->project_status_id == $projectStatus->id)>{{ $projectStatus->name }}</option>
                                    @endforeach
                                </select>
                                @if(!empty($errors->first('project_status_id')))
                                    <div class="invalid-feedback">{{ $errors->first('project_status_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.priority')</label>
                                <select class="form-control" name="project_priority_id" id="project_priority_dropdown">
                                    @foreach($projectPriorities as $projectPriority)
                                        <option data-value="{{ $projectPriority }}" value="{{ $projectPriority }}" @selected(old('project_priority_id') ? old('project_priority_id') == $projectPriority->id : $model->project_priority_id == $projectPriority->id)>{{ $projectPriority->name }}</option>
                                    @endforeach
                                </select>
                                @if(!empty($errors->first('project_priority_id')))
                                    <div class="invalid-feedback">{{ $errors->first('project_priority_id') }}</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.contractType')</label>
                                <select class="form-control" name="project_contract_type_id" id="project_contract_type_dropdown">
                                    @foreach($projectContractTypes as $projectContractType)
                                        <option data-value="{{ $projectContractType }}" value="{{ $projectContractType }}" @selected(old('project_contract_type_id') ? old('project_contract_type_id') == $projectContractType->id : $model->project_contract_type_id == $projectContractType->id)>{{ $projectContractType->name }}</option>
                                    @endforeach
                                </select>
                                @if(!empty($errors->first('project_contract_type_id')))
                                    <div class="invalid-feedback">{{ $errors->first('project_contract_type_id') }}</div>
                                @endif
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <label class="form-label">@lang('translation.fields.projectSource')</label>
                                    <select class="form-control" name="project_source_id" id="project_source_dropdown">
                                        @foreach($projectSources as $projectSource)
                                            <option value="{{ $projectSource->id }}" @selected(old('project_source_id') ? old('project_source_id') == $projectSource->id : $model->project_source_id == $projectSource->id)>{{ $projectSource->name }}</option>
                                        @endforeach
                                    </select>
                                    @if(!empty($errors->first('project_source_id')))
                                        <div class="invalid-feedback">{{ $errors->first('project_source_id') }}</div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <label class="form-label">@lang('translation.fields.color')</label>
                                    <input type="text" class="form-control colorpicker" name="color" placeholder="@lang('translation.fields.color')" value="{{ old('color', $model?->color ?? '') }}">
                                    @if(!empty($errors->first('color')))
                                        <div class="invalid-feedback">{{ $errors->first('color') }}</div>
                                    @endif
                                </div>
                                @push('scripts')
                                    <script>
                                        $(function() {
                                            $(".colorpicker").spectrum({});
                                        });
                                    </script>
                                @endpush
                            </div>
                            <h5 class="mt-3">@lang('translation.headings.financialInformation')</h5>
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">@lang('translation.fields.currency')</label>
                                    <select class="form-control" name="currency_id" id="currency_dropdown">
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}" @selected(old('currency_id') ? old('currency_id') == $currency->id : $model->currency_id == $currency->id)>{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                    @if(!empty($errors->first('currency_id')))
                                        <div class="invalid-feedback">{{ $errors->first('currency_id') }}</div>
                                    @endif
                                </div>
                                <div class="col-3">
                                    <label class="form-label">@lang('translation.fields.flatEstimatedValue')</label>
                                    <input type="text" class="form-control" name="flat_estimated_value" placeholder="@lang('translation.fields.flatEstimatedValue')" value="{{ old('flat_estimated_value', $model->flat_estimated_value) }}">
                                    @if(!empty($errors->first('flat_estimated_value')))
                                        <div class="invalid-feedback">{{ $errors->first('flat_estimated_value') }}</div>
                                    @endif
                                </div>
                                <div class="col-3">
                                    <label class="form-label">@lang('translation.fields.flatNegotiatedValue')</label>
                                    <input type="text" class="form-control" name="flat_negotiated_value" placeholder="@lang('translation.fields.flatNegotiatedValue')" value="{{ old('flat_negotiated_value', $model->flat_negotiated_value) }}">
                                    @if(!empty($errors->first('flat_negotiated_value')))
                                        <div class="invalid-feedback">{{ $errors->first('flat_negotiated_value') }}</div>
                                    @endif
                                </div>
                                <div class="col-3">
                                    <label class="form-label">@lang('translation.fields.flatAcceptedValue')</label>
                                    <input type="text" class="form-control" name="flat_accepted_value" placeholder="@lang('translation.fields.flatAcceptedValue')" value="{{ old('flat_accepted_value', $model->flat_accepted_value) }}">
                                    @if(!empty($errors->first('flat_accepted_value')))
                                        <div class="invalid-feedback">{{ $errors->first('flat_accepted_value') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            function formatValue (state) {
                if (!state.id) {
                    return state.text;
                }

                let model = JSON.parse(state.element.getAttribute('data-value'));

                var template = $(
                    '<span style="display: inline-block; width: 22px; height: 22px; background-color: '+model.color+'"></span>' +
                    '<span style="position: relative; top: -6px; left: 10px;">' + model.name + '</span>'
                );

                return template;
            };

            $('#project_status_dropdown').select2({
                placeholder: 'Select an option',
                templateResult: formatValue
            });

            $('#project_priority_dropdown').select2({
                placeholder: 'Select an option',
                templateResult: formatValue
            });

            $('#project_contract_type_dropdown').select2({
                placeholder: 'Select an option',
                templateResult: formatValue
            });

            $('#project_source_dropdown').select2({
                placeholder: 'Select an option',
            });
        });
    </script>
@endsection
