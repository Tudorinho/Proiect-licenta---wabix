@extends('layouts.master')

@section('title')
    @lang('translation.deal.deals')
@endsection

@section('css')
    <style>
        .message_wrapper{
            margin-bottom: 10px;
            border-bottom: 1px solid #cccccc;
        }

        .message_wrapper_last_message{
            background-color: #fcf8e3;
        }

        .card-body{
            padding: 10px !important;
        }

        .card{
            margin-bottom: 5px !important;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.deal.deals')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('deals.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
            <a href="{{ route('deals.index') }}" type="button" class="btn btn-info waves-effect waves-light" style="float: right; margin-left: 5px;">List View</a>
        </div>
    </div>

    <div class="" style="display: flex; overflow: scroll">
        @foreach($dealsStatuses as $dealsStatus)
            <div class="" style="float: left; min-width: 350px; margin-right: 20px;">
                <div class="card">
                    <div class="card-header" style="font-size: 12px; text-align: center; color: {{ $dealsStatus->color }}; border: 1.5px solid {{ $dealsStatus->color }}">{{ $dealsStatus->name }}</div>
                </div>
                <?php $dealsData = $deals[$dealsStatus->id]; ?>
                @foreach($dealsData as $deal)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7" style="font-weight: bold; font-size: 16px; max-width: 200px;">
                                    {{ $deal->title }}
                                </div>
                                <div class="col-5" style="padding: 0px;">
                                    @include('deals.partials.deal-edit', ['deal' => $deal])
                                    @include('deals.partials.deal-contact', ['deal' => $deal])
                                    @include('deals.partials.deal-emails-thread', ['deal' => $deal])
                                    @include('deals.partials.deal-notes', ['deal' => $deal])
                                </div>
                            </div>
                            <div>
                                @if($deal->type == 'upsell')
                                    <label class="badge badge-pill badge-soft-danger font-size-11">{{ $deal->type }}</label>
                                @else
                                    <label class="badge badge-pill badge-soft-warning font-size-11">{{ $deal->type }}</label>
                                @endif

                                <label class="badge badge-pill badge-soft-dark font-size-11">{{ $deal->dealSource->name }}</label>

                                <label class="badge badge-pill badge-soft-primary font-size-11">{{ $deal->deal_size.' '.$deal->currency->symbol }}</label>
                            </div>
                            <div class="row">
                                <div class="col-12" style="max-width: 350px;">
                                    <span style="font-weight: bold;">Contact: </span> {{ $deal->companyContact->first_name.' '.$deal->companyContact->last_name.'('.$deal->companyContact->company->name.')' }}
                                </div>
                            </div>
                            <?php
                                $latestNote = $deal->dealNotes->sortByDesc('created_at')->first()?->note;
                            ?>
                            @if(!empty($latestNote))
                                <div class="mt-2">
                                    <div style="max-width: 350px;">
                                        <span style="font-weight: bold;">Latest Note: </span> {{ $latestNote }}
                                    </div>
                                </div>
                            @endif
                            <div class="mt-2">
                                <div style="max-width: 350px;">
                                    <span style="font-weight: bold;">Description: </span>{{ substr($deal->description, 0, 100) }}
                                </div>
                                <div>
                                    @include('deals.partials.deal-description', ['deal' => $deal])
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

@endsection
@section('script')
@endsection
