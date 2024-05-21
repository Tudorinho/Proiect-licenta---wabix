@extends('layouts.master')

@section('title')
    @lang('translation.emailThread.editEmailThread')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('emails-threads.index') }}">@lang('translation.emailThread.emailsThreads')</a>
        @endslot
        @slot('title')
            @lang('translation.emailThread.addEmailThread')
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
                    <form action="{{ route('emails-threads.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.identifier')</label>
                                <input type="text" class="form-control" name="identifier" placeholder="@lang('translation.fields.identifier')" value="{{ old('identifier', $model?->identifier ?? '') }}">
                                @if(!empty($errors->first('identifier')))
                                    <div class="invalid-feedback">{{ $errors->first('identifier') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.companiesContactsId')</label>
                                <select class="form-control" name="companies_contacts_id" id="companies_contacts_id_dropdown">
                                    @foreach($companiesContacts as $value)
                                        <option value="{{ $value->id }}" {{ (old('companies_contacts_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->first_name }}</option>
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
