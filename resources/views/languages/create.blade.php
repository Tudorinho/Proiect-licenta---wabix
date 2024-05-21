@extends('layouts.master')

@section('title')
    @lang('translation.languages.addLanguage')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('languages.index') }}">@lang('translation.languages.languages')</a>
        @endslot
        @slot('title')
            @lang('translation.languages.addLanguage')
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
                    <form action="{{ route('languages.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">

                            {{-- name --}}
                            <div class="col-3">
                                <label class="form-label">@lang('translation.languages.languageName')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.languages.languageName')" value="{{ old('name') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
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
