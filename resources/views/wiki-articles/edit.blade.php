@extends('layouts.master')

@section('title')
    @lang('translation.wikiArticle.editWikiArticle')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('wiki-articles.index') }}">@lang('translation.wikiArticle.wikiArticles')</a>
        @endslot
        @slot('title')
            @lang('translation.wikiArticle.addWikiArticle')
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
                    <form action="{{ route('wiki-articles.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.title')</label>
                                <input type="text" class="form-control" name="title" placeholder="@lang('translation.fields.title')" value="{{ old('title', $model?->title ?? '') }}">
                                @if(!empty($errors->first('title')))
                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="col-3">
                                <label class="form-label">@lang('translation.fields.wikiCategoriesId')</label>
                                <select class="form-control" name="wiki_categories_id" id="wiki_categories_id_dropdown">
                                    @foreach($wikiCategories as $value)
                                        <option value="{{ $value->id }}" {{ (old('wiki_categories_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('wiki_categories_id'))
                                    <div class="invalid-feedback">{{ $errors->first('wiki_categories_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#wiki_categories_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.body')</label>
                                <textarea id="wiki_article_body" class="form-control" name="body" placeholder="@lang('translation.fields.body')">{{ old('body', $model?->body ?? '') }}</textarea>
                                @if(!empty($errors->first('body')))
                                    <div class="invalid-feedback">{{ $errors->first('body') }}</div>
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
    <script src="{{ URL::asset('build/libs/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            document.getElementById("wiki_article_body")&&tinymce.init({
                selector:"textarea#wiki_article_body",
                height:350,
                plugins:["advlist","autolink","lists","link","image","charmap","preview","anchor","searchreplace","visualblocks","code","fullscreen","insertdatetime","media","table","help","wordcount"],
                toolbar:"undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help",
                content_style:'body { font-family:"Poppins",sans-serif; font-size:16px }'
            });
        });
    </script>
@endsection
