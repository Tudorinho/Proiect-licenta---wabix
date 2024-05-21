@extends('layouts.master')

@section('title')
    @lang('translation.dealsStatuses.addDealStatus')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('deals-statuses.index') }}">@lang('translation.dealsStatuses.dealsStatuses')</a>
        @endslot
        @slot('title')
            @lang('translation.dealsStatuses.addDealStatus')
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
                    <form action="{{ route('deals-statuses.store') }}" method="POST">
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
                                <label class="form-label">@lang('translation.fields.order')</label>
                                <input type="text" class="form-control" name="order" placeholder="@lang('translation.fields.order')" value="{{ old('order', $model?->order ?? '') }}">
                                @if(!empty($errors->first('order')))
                                    <div class="invalid-feedback">{{ $errors->first('order') }}</div>
                                @endif
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.color')</label>
                                <input type="text" class="form-control colorpicker" name="color" placeholder="@lang('translation.fields.color')" value="{{ old('color', $model?->color ?? '') }}">
                                @if(!empty($errors->first('color')))
                                    <div class="invalid-feedback">{{ $errors->first('color') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $(".colorpicker").spectrum({});
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
