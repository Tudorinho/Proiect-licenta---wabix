@extends('layouts.master')

@section('title')
    @lang('translation.user.addUser')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('users.index') }}">@lang('translation.user.users')</a>
        @endslot
        @slot('title')
            @lang('translation.user.editProfile')
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
                    <form action="{{ route('users.change-password') }}" method="POST">
                        {{ csrf_field() }}
                        <h5 class="mt-3">@lang('translation.headings.changePassword')</h5>

                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.currentPassword')</label>
                                <input type="password" class="form-control" name="current_password" placeholder="@lang('translation.fields.currentPassword')" value="{{ old('current_password') }}">
                                @if(!empty($errors->first('current_password')))
                                    <div class="invalid-feedback">{{ $errors->first('current_password') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.newPassword')</label>
                                <input type="password" class="form-control" name="new_password" placeholder="@lang('translation.fields.newPassword')" value="{{ old('new_password') }}">
                                @if(!empty($errors->first('new_password')))
                                    <div class="invalid-feedback">{{ $errors->first('new_password') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.confirmPassword')</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="@lang('translation.fields.confirmPassword')" value="{{ old('confirm_password') }}">
                                @if(!empty($errors->first('confirm_password')))
                                    <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
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
