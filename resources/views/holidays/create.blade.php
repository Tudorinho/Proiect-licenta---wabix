@extends('layouts.master')

@section('title')
    @lang('translation.holiday.addHoliday')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('holidays.index') }}">@lang('translation.holiday.holidays')</a>
        @endslot
        @slot('title')
            @lang('translation.holiday.addHoliday')
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
                    <form action="{{ route('holidays.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')" value="{{ old('name', $model?->name ?? '') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.startDate')</label>
                                <input type="text" class="form-control" id="start_date_datepicker" name="start_date" placeholder="@lang('translation.fields.startDate')" value="{{ old('start_date', $model?->start_date ?? '') }}">
                                @if(!empty($errors->first('start_date')))
                                    <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#start_date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.endDate')</label>
                                <input type="text" class="form-control" id="end_date_datepicker" name="end_date" placeholder="@lang('translation.fields.endDate')" value="{{ old('end_date', $model?->end_date ?? '') }}">
                                @if(!empty($errors->first('end_date')))
                                    <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#end_date_datepicker').datepicker({
                                            "format": "yyyy-mm-dd"
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
