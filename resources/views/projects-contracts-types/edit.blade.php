@extends('layouts.master')

@section('title')
    @lang('translation.projectContractType.editProjectContractType')
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
            <a href="{{ route('projects-contracts-types.index') }}">@lang('translation.projectContractType.projectsContractsTypes')</a>
        @endslot
        @slot('title')
            @lang('translation.projectContractType.editProjectContractType')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('projects-contracts-types.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')" value="{{ $model->name }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label">@lang('translation.color')</label>
                                <input type="text" class="form-control colorpicker" name="color" placeholder="@lang('translation.color')">
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
            $(".colorpicker").spectrum({
                'color': '{{ $model->color }}'
            });
        });
    </script>
@endsection
