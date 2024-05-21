@extends('layouts.master')

@section('title')
    @lang('translation.coldCallingListsContacts.addColdCallingListsContacts')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('cold-calling-lists-contacts.index') }}">@lang('translation.coldCallingListsContacts.coldCallingListsContacts')</a>
        @endslot
        @slot('title')
            @lang('translation.coldCallingListsContacts.addColdCallingListsContacts')
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
                    <form action="{{ route('cold-calling-lists-contacts.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.coldCallingListsId')</label>
                                <select class="form-control" name="cold_calling_lists_id" id="cold_calling_lists_id_dropdown">
                                    @foreach($coldCallingLists as $value)
                                        <option value="{{ $value->id }}" {{ (old('cold_calling_lists_id') == $value->id || (isset($model) && $model->cold_calling_lists_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('cold_calling_lists_id'))
                                    <div class="invalid-feedback">{{ $errors->first('cold_calling_lists_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#cold_calling_lists_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.companiesContactsId')</label>
                                <select class="form-control" name="companies_contacts_id" id="companies_contacts_id_dropdown">
                                    @foreach($companyContacts as $value)
                                        <option value="{{ $value->id }}" {{ (old('companies_contacts_id') == $value->id || (isset($model) && $model->companies_contacts_id == $value->id)) ? 'selected' : '' }}>{{ $value->first_name.' '.$value->last_name.'('.$value->company->name.')' }}</option>
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
