@extends('layouts.master')

@section('title')
    @lang('translation.coldEmailingCredentials.addColdEmailingCredentials')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('cold-emailing-credentials.index') }}">@lang('translation.coldEmailingCredentials.coldEmailingCredentials')</a>
        @endslot
        @slot('title')
            @lang('translation.coldEmailingCredentials.addColdEmailingCredentials')
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
                    <form action="{{ route('cold-emailing-credentials.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-4 ">
                                <label class="form-label">@lang('translation.fields.email')</label>
                                <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ old('email', $model?->email ?? '') }}">
                                @if(!empty($errors->first('email')))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-4 ">
                                <label class="form-label">@lang('translation.fields.username')</label>
                                <input type="text" class="form-control" name="username" placeholder="@lang('translation.fields.username')" value="{{ old('username', $model?->username ?? '') }}">
                                @if(!empty($errors->first('username')))
                                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                @endif
                            </div>
                            <div class="col-4 ">
                                <label class="form-label">@lang('translation.fields.password')</label>
                                <input type="text" class="form-control" name="password" placeholder="@lang('translation.fields.password')" value="{{ old('password', $model?->password ?? '') }}">
                                @if(!empty($errors->first('password')))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
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
