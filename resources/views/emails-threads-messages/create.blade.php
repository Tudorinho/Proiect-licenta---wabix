@extends('layouts.master')

@section('title')
    @lang('translation.emailThreadMessage.addEmailThreadMessage')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('emails-threads-messages.index') }}">@lang('translation.emailThreadMessage.emailsThreadsMessages')</a>
        @endslot
        @slot('title')
            @lang('translation.emailThreadMessage.addEmailThreadMessage')
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
                    <form action="{{ route('emails-threads-messages.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.emailsThreadsId')</label>
                                <select class="form-control" name="emails_threads_id" id="emails_threads_id_dropdown">
                                    @foreach($emailsThreads as $value)
                                        <option value="{{ $value->id }}" {{ (old('emails_threads_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->identifier }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('emails_threads_id'))
                                    <div class="invalid-feedback">{{ $errors->first('emails_threads_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#emails_threads_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.date')</label>
                                <input type="text" class="form-control" id="date_datepicker" name="date" placeholder="@lang('translation.fields.date')" value="{{ old('date', $model?->date ?? '') }}">
                                @if(!empty($errors->first('date')))
                                    <div class="invalid-feedback">{{ $errors->first('date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.from')</label>
                                <input type="text" class="form-control" name="from" placeholder="@lang('translation.fields.from')" value="{{ old('from', $model?->from ?? '') }}">
                                @if(!empty($errors->first('from')))
                                    <div class="invalid-feedback">{{ $errors->first('from') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.to')</label>
                                <input type="text" class="form-control" name="to" placeholder="@lang('translation.fields.to')" value="{{ old('to', $model?->to ?? '') }}">
                                @if(!empty($errors->first('to')))
                                    <div class="invalid-feedback">{{ $errors->first('to') }}</div>
                                @endif
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.subject')</label>
                                <input type="text" class="form-control" name="subject" placeholder="@lang('translation.fields.subject')" value="{{ old('subject', $model?->subject ?? '') }}">
                                @if(!empty($errors->first('subject')))
                                    <div class="invalid-feedback">{{ $errors->first('subject') }}</div>
                                @endif
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.message')</label>
                                <textarea class="form-control" name="message" placeholder="@lang('translation.fields.message')">{{ old('message', $model?->message ?? '') }}</textarea>
                                @if(!empty($errors->first('message')))
                                    <div class="invalid-feedback">{{ $errors->first('message') }}</div>
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
