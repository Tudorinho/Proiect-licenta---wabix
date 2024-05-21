@extends('layouts.master')

@section('title') @lang('translation.general.dashboard') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
    @endsection

    <div class="row">
        <div class="col-4">
            @include('home.partials.welcome-back')
        </div>
        <div class="col-4">
            @include('home.partials.monthly-worklogs')
        </div>
        <div class="col-4">
            @include('home.partials.leaves-overview')
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            @include('home.partials.leaves-calendar')
        </div>
        <div class="col-4">
            @include('home.partials.holidays-calendar')
        </div>
        <div class="col-4">
            @include('home.partials.events-calendar')
        </div>
    </div>

    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <div class="row">
            <div class="col-lg-12">
                @include('home.partials.deals')
            </div>
        </div>
    @endif
@endsection

@section('script')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
@endsection

