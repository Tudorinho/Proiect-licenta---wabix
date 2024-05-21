@extends('layouts.master')

@section('title')
    @lang('translation.deal.editDeal')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('deals.index') }}">@lang('translation.deal.deals')</a>
        @endslot
        @slot('title')
            @lang('translation.deal.addDeal')
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
                    <form action="{{ route('deals.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
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
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.companiesContactsId')</label>
                                <select class="form-control" name="companies_contacts_id" id="companies_contacts_id_dropdown">
                                    @foreach($companiesContacts as $value)
                                        <option value="{{ $value->id }}" {{ (old('companies_contacts_id') == $value->id || (isset($model) && $model->companies_contacts_id == $value->id)) ? 'selected' : '' }}>{{ $value->getFormattedName() }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('companies_contacts_id'))
                                    <div class="invalid-feedback">{{ $errors->first('companies_contacts_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#companies_contacts_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.dealsStatusesId')</label>
                                <select class="form-control" name="deals_statuses_id" id="deals_statuses_id_dropdown">
                                    @foreach($dealsStatuses as $value)
                                        <option value="{{ $value->id }}" {{ (old('deals_statuses_id') == $value->id || (isset($model) && $model->deals_statuses_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('deals_statuses_id'))
                                    <div class="invalid-feedback">{{ $errors->first('deals_statuses_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#deals_statuses_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.dealsSourcesId')</label>
                                <select class="form-control" name="deals_sources_id" id="deals_sources_id_dropdown">
                                    @foreach($dealsSources as $value)
                                        <option value="{{ $value->id }}" {{ (old('deals_sources_id') == $value->id || (isset($model) && $model->deals_sources_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('deals_sources_id'))
                                    <div class="invalid-feedback">{{ $errors->first('deals_sources_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#deals_sources_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-2 mt-3">
                                <label class="form-label">@lang('translation.fields.dealSize')</label>
                                <input type="text" class="form-control" name="deal_size" placeholder="@lang('translation.fields.dealSize')" value="{{ old('deal_size', $model?->deal_size ?? '') }}">
                                @if(!empty($errors->first('deal_size')))
                                    <div class="invalid-feedback">{{ $errors->first('deal_size') }}</div>
                                @endif
                            </div>
                            <div class="col-2 mt-3">
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
                            <div class="col-2 mt-3">
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
                            <div class="col-6 mt-3">
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
