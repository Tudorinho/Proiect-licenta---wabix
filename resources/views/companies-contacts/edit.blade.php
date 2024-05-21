@extends('layouts.master')

@section('title')
    @lang('translation.companyContact.editCompanyContact')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('companies-contacts.index') }}">@lang('translation.companyContact.companiesContacts')</a>
        @endslot
        @slot('title')
            @lang('translation.companyContact.addCompanyContact')
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
                    <form action="{{ route('companies-contacts.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.firstName')</label>
                                <input type="text" class="form-control" name="first_name" placeholder="@lang('translation.fields.firstName')" value="{{ old('first_name', $model?->first_name ?? '') }}">
                                @if(!empty($errors->first('first_name')))
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.lastName')</label>
                                <input type="text" class="form-control" name="last_name" placeholder="@lang('translation.fields.lastName')" value="{{ old('last_name', $model?->last_name ?? '') }}">
                                @if(!empty($errors->first('last_name')))
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.position')</label>
                                <input type="text" class="form-control" name="position" placeholder="@lang('translation.fields.position')" value="{{ old('position', $model?->position ?? '') }}">
                                @if(!empty($errors->first('position')))
                                    <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.email')</label>
                                <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ old('email', $model?->email ?? '') }}">
                                @if(!empty($errors->first('email')))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.companyId')</label>
                                <select class="form-control" name="company_id" id="company_id_dropdown">
                                    @foreach($companies as $value)
                                        <option value="{{ $value->id }}" {{ (old('company_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('company_id'))
                                    <div class="invalid-feedback">{{ $errors->first('company_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#company_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.phone')</label>
                                <input type="text" class="form-control" name="phone" placeholder="@lang('translation.fields.phone')" value="{{ old('phone', $model?->phone ?? '') }}">
                                @if(!empty($errors->first('phone')))
                                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
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
