@extends('layouts.master')

@section('title')
    @lang('translation.coldEmailingRules.addColdEmailingRules')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('cold-emailing-rules.index') }}">@lang('translation.coldEmailingRules.coldEmailingRules')</a>
        @endslot
        @slot('title')
            @lang('translation.coldEmailingRules.addColdEmailingRules')
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
                    <form action="{{ route('cold-emailing-rules.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')" value="{{ old('name', $model?->name ?? '') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.coldEmailingCredentialsId')</label>
                                <select class="form-control" name="cold_emailing_credentials_id" id="cold_emailing_credentials_id_dropdown">
                                    @foreach($coldEmailingCredentials as $value)
                                        <option value="{{ $value->id }}" {{ (old('cold_emailing_credentials_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->email }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('cold_emailing_credentials_id'))
                                    <div class="invalid-feedback">{{ $errors->first('cold_emailing_credentials_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#cold_emailing_credentials_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
						</div>
						<h5 class="mt-3">@lang('translation.headings.searchCriteria')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.subject')</label>
                                <input type="text" class="form-control" name="subject" placeholder="@lang('translation.fields.subject')" value="{{ old('subject', $model?->subject ?? '') }}">
                                @if(!empty($errors->first('subject')))
                                    <div class="invalid-feedback">{{ $errors->first('subject') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.since')</label>
                                <input type="text" class="form-control" id="since_datepicker" name="since" placeholder="@lang('translation.fields.since')" value="{{ old('since', $model?->since ?? '') }}">
                                @if(!empty($errors->first('since')))
                                    <div class="invalid-feedback">{{ $errors->first('since') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#since_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.before')</label>
                                <input type="text" class="form-control" id="before_datepicker" name="before" placeholder="@lang('translation.fields.before')" value="{{ old('before', $model?->before ?? '') }}">
                                @if(!empty($errors->first('before')))
                                    <div class="invalid-feedback">{{ $errors->first('before') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#before_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
						</div>
						<h5 class="mt-3">@lang('translation.headings.taskConfiguration')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.tasksListsId')</label>
                                <select class="form-control" name="tasks_lists_id" id="tasks_lists_id_dropdown">
                                    @foreach($tasksLists as $value)
                                        <option value="{{ $value->id }}" {{ (old('tasks_lists_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tasks_lists_id'))
                                    <div class="invalid-feedback">{{ $errors->first('tasks_lists_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#tasks_lists_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
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
