@extends('layouts.master')

@section('title')
    @lang('translation.projectPriority.addProjectPriority')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .invalid-feedback{
            display: block !important;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('projects-priorities.index') }}">@lang('translation.projectPriority.projectsPriorities')</a>
        @endslot
        @slot('title')
            @lang('translation.projectPriority.addProjectPriority')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('projects-priorities.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.color')</label>
                                <input type="text" class="form-control colorpicker" name="color" placeholder="@lang('translation.fields.color')">
                                @if(!empty($errors->first('color')))
                                    <div class="invalid-feedback">{{ $errors->first('color') }}</div>
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
    <script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script>
        $(function() {
            $(".colorpicker").spectrum({});
        });
    </script>
@endsection
