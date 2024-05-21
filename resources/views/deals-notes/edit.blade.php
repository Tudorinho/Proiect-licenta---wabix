@extends('layouts.master')

@section('title')
    @lang('translation.dealsNotes.editDealNote')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('deals-notes.index') }}">@lang('translation.dealsNotes.dealsNotes')</a>
        @endslot
        @slot('title')
            @lang('translation.dealsNotes.addDealNote')
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
                    <form action="{{ route('deals-notes.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.dealsId')</label>
                                <select class="form-control" name="deals_id" id="deals_id_dropdown">
                                    @foreach($deals as $value)
                                        <option value="{{ $value->id }}" {{ (old('deals_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->title }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('deals_id'))
                                    <div class="invalid-feedback">{{ $errors->first('deals_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#deals_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.note')</label>
                                <textarea class="form-control" name="note" placeholder="@lang('translation.fields.note')">{{ old('note', $model?->note ?? '') }}</textarea>
                                @if(!empty($errors->first('note')))
                                    <div class="invalid-feedback">{{ $errors->first('note') }}</div>
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
