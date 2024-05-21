@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent

    @section('css')
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="row">
                @foreach($roles as $role)
                    <div class="col" style="font-weight: bold;">{{$role}}</div>
                @endforeach
            </div>

            <div class="row">
                @foreach($routes as $role => $roleRoutes)
                        <div class="col" style="border-bottom: 1px solid #c4c4c4;">
                        @foreach($roleRoutes as $route)
                            @if(!empty($role))
                                <div>
                                    <input type="checkbox">
                                </div>
                            @else
                                <div>{{ $route['name'].' '.$route['url'] }}</div>
                            @endif
                        @endforeach
                        </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection

