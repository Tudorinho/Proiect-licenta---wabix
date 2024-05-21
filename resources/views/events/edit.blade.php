@extends('layouts.master')

@section('title')
    @lang('translation.event.editEvent')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('events.index') }}">@lang('translation.event.events')</a>
        @endslot
        @slot('title')
            @lang('translation.event.addEvent')
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
                    <form action="{{ route('events.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
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
                            <div class="col-3 ">
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
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.eventsTypesId')</label>
                                <select class="form-control" name="events_types_id" id="events_types_id_dropdown">
                                    @foreach($eventsTypes as $value)
                                        <option value="{{ $value->id }}" {{ (old('events_types_id') == $value->id || (isset($model) && $model->events_types_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('events_types_id'))
                                    <div class="invalid-feedback">{{ $errors->first('events_types_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#events_types_id_dropdown').select2({
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
