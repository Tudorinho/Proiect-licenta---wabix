@extends('layouts.master')

@section('title')
    @lang('translation.company.editCompany')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('companies.index') }}">@lang('translation.company.companies')</a>
        @endslot
        @slot('title')
            @lang('translation.company.editCompany')
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
                    <form action="{{ route('companies.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')" value="{{ old('name', $model?->name ?? '') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.registrationNumber')</label>
                                <input type="text" class="form-control" name="registration_number" placeholder="@lang('translation.fields.registrationNumber')" value="{{ old('registration_number', $model?->registration_number ?? '') }}">
                                @if(!empty($errors->first('registration_number')))
                                    <div class="invalid-feedback">{{ $errors->first('registration_number') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.type')</label>
                                <select class="form-control" name="type" id="type_dropdown">
                                    @foreach($types as $value)
                                        <option value="{{ $value }}" {{ (old('type') == $value || (isset($model) && $model->type == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('type'))
                                    <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#type_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.website')</label>
                                <input type="text" class="form-control" name="website" placeholder="@lang('translation.fields.website')" value="{{ old('website', $model?->website ?? '') }}">
                                @if(!empty($errors->first('website')))
                                    <div class="invalid-feedback">{{ $errors->first('website') }}</div>
                                @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">@lang('translation.fields.addressLine1')</label>
                                <input type="text" class="form-control" name="address_line_1" placeholder="@lang('translation.fields.addressLine1')" value="{{ old('address_line_1', $model?->address_line_1 ?? '') }}">
                                @if(!empty($errors->first('address_line_1')))
                                    <div class="invalid-feedback">{{ $errors->first('address_line_1') }}</div>
                                @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">@lang('translation.fields.addressLine2')</label>
                                <input type="text" class="form-control" name="address_line_2" placeholder="@lang('translation.fields.addressLine2')" value="{{ old('address_line_2', $model?->address_line_2 ?? '') }}">
                                @if(!empty($errors->first('address_line_2')))
                                    <div class="invalid-feedback">{{ $errors->first('address_line_2') }}</div>
                                @endif
                            </div>

                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.avgEmployeesCount')</label>
                                <input type="text" class="form-control" name="avg_employees_count" placeholder="@lang('translation.fields.avgEmployeesCount')" value="{{ old('avg_employees_count', $model?->avg_employees_count ?? '') }}">
                                @if(!empty($errors->first('avg_employees_count')))
                                    <div class="invalid-feedback">{{ $errors->first('avg_employees_count') }}</div>
                                @endif
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.income')</label>
                                <input type="text" class="form-control" name="income" placeholder="@lang('translation.fields.income')" value="{{ old('income', $model?->income ?? '') }}">
                                @if(!empty($errors->first('income')))
                                    <div class="invalid-feedback">{{ $errors->first('income') }}</div>
                                @endif
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.profit')</label>
                                <input type="text" class="form-control" name="profit" placeholder="@lang('translation.fields.profit')" value="{{ old('profit', $model?->profit ?? '') }}">
                                @if(!empty($errors->first('profit')))
                                    <div class="invalid-feedback">{{ $errors->first('profit') }}</div>
                                @endif
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.currencyId')</label>
                                <select class="form-control" name="currency_id" id="currency_id_dropdown">
                                    @foreach($currencies as $value)
                                        <option value="{{ $value->id }}" {{ (old('currency_id') == $value->id || (isset($model) && $model->currency_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('currency_id'))
                                    <div class="invalid-feedback">{{ $errors->first('currency_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#currency_id_dropdown').select2({
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
