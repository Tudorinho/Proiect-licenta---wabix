@extends('layouts.master')

@section('title')
    @lang('translation.wikiArticle.wikiArticles')
@endsection

@section('css')
    <style>
        img{
            max-width: 100%;
        }

        a .card:hover{
            background-color: #cccccc;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.wikiArticle.wiki')
        @endslot
    @endcomponent

    @if(empty($wikiCategoryId) && empty($wikiArticleId))
        <div class="row mb-3">
            @foreach($wikiCategories as $wikiCategory)
                <a href="{{ route('wiki-articles.wiki', ['wikiCategoryId' => $wikiCategory->id]) }}">
                    <div class="card">
                        <div class="card-body">
                            {{ $wikiCategory->name }} ({{ $wikiCategory->getArticlesCount() }} articles)
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    @if(!empty($wikiCategoryId) && empty($wikiArticleId))
        <div class="row mb-3">
            <div class="card" style="margin-bottom: 0px;">
                <a href="{{ route('wiki-articles.wiki') }}">Go back to Wiki Categories</a>
            </div>
        </div>

        @foreach($wikiArticles as $wikiArticle)
            <a href="{{ route('wiki-articles.wiki', ['wikiCategoryId' => $wikiArticle->wiki_categories_id, 'wikiArticleId' => $wikiArticle->id]) }}">
                <div class="row mb-3">
                    <div class="card">
                        <div class="card-body">
                            {{ $wikiArticle->title }}
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    @endif

    @if(!empty($wikiCategoryId) && !empty($wikiArticleId))
        <div class="row mb-3">
            <div class="card" style="margin-bottom: 0px;">
                <a href="{{ route('wiki-articles.wiki', ['wikiCategoryId' => $currentWikiArticle->wiki_categories_id]) }}">Go back to {{ $currentWikiArticle->wikiCategory->name }} Wiki</a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="card">
                <div class="card-body">
                    {!! $currentWikiArticle->body !!}
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
@endsection
