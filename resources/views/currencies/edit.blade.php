@extends('layouts.master')

@section('title')
    @lang('translation.user.addCurrency')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('currencies.index') }}">@lang('translation.user.currencies')</a>
        @endslot
        @slot('title')
            @lang('translation.user.addCurrency')
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
                    <form action="{{ route('currencies.update', ['id' => $model->id]) }}" method="POST">
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
                                <label class="form-label">@lang('translation.fields.symbol')</label>
                                <input type="text" class="form-control" name="symbol" placeholder="@lang('translation.fields.symbol')" value="{{ old('symbol', $model?->symbol ?? '') }}">
                                @if(!empty($errors->first('symbol')))
                                    <div class="invalid-feedback">{{ $errors->first('symbol') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.rate')</label>
                                <input type="text" class="form-control" name="rate" placeholder="@lang('translation.fields.rate')" value="{{ old('rate', $model?->rate ?? '') }}">
                                @if(!empty($errors->first('rate')))
                                    <div class="invalid-feedback">{{ $errors->first('rate') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.isDefault')</label>
                                <select class="form-control" name="is_default" id="is_default_dropdown">
                                    @foreach($isDefaultValues as $value)
                                        <option value="{{ $value }}" {{ (old('is_default') == $value || (isset($model) && $model->is_default == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('is_default'))
                                    <div class="invalid-feedback">{{ $errors->first('is_default') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#is_default_dropdown').select2({
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
