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
            @lang('translation.user.addUser')
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
                    <form action="{{ route('users.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.email')</label>
                                <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ old('email', $model?->email ?? '') }}">
                                @if(!empty($errors->first('email')))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.role')</label>
                                <select class="form-control" name="role" id="role_dropdown">
                                    @foreach($roles as $value)
                                        <option value="{{ $value }}" {{ (old('role') == $value || (isset($model) && $model->role == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('role'))
                                    <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#role_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.password')</label>
                                <input type="password" class="form-control" name="password" placeholder="@lang('translation.fields.password')" value="{{ old('password', $model?->password ?? '') }}">
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
