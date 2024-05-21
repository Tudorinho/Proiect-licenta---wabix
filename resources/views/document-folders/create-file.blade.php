@extends('layouts.master')

@section('title')
    @lang('translation.documentFolders.addFile')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('document-folders.index') }}">@lang('translation.documentFolders.documentFolders')</a>
        @endslot
        @slot('title')
            @lang('translation.documentFolders.addFile')
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
                    <form action="{{ route('document-folders.store-file') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">

                            {{-- document_folder_id --}}
                            <input type="hidden" name="document_folder_id" value="{{request()->input('document_folder_id')}}">

                            {{-- name --}}
                            <div class="col-6">
                                <label class="form-label">@lang('translation.documentFolders.fileName')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.documentFolders.fileName')" value="{{ old('name', $file?->name ?? '') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            {{-- Data --}}
                            <div class="col-6">
                                <label class="form-label">@lang('translation.documentFolders.fileData')</label>
                                <input type="text" class="form-control" name="data" placeholder="@lang('translation.documentFolders.fileData')" value="{{ old('data', $file?->data ?? '') }}">
                                @if(!empty($errors->first('data')))
                                    <div class="invalid-feedback">{{ $errors->first('data') }}</div>
                                @endif
                            </div>

                            {{-- Type --}}
                            <div class="col-6 mt-2">
                                <label class="form-label">@lang('translation.documentFolders.fileType')</label>
                                <select class="form-control" name="type">
                                    <option value="url" {{ old('type', $file->type ?? '') == 'url' ? 'selected' : '' }}>URL</option>
                                    <option value="file" {{ old('type', $file->type ?? '') == 'file' ? 'selected' : '' }}>File</option>
                                </select>
                                @if(!empty($errors->first('type')))
                                    <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                                @endif
                            </div>


                            {{-- Language --}}

                            <div class="col-6 mt-2">
                                <label class="form-label">@lang('translation.documentFolders.fileLanguage')</label>
                                <select class="form-control" name="language_id" id="language_dropdown">
                                    <option value="">@lang('translation.documentFolders.selectLanguage')</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}" {{ old('language_id', $file->language_id ?? '') == $language->id ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('language_id'))
                                    <div class="invalid-feedback">{{ $errors->first('language_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                            <script>
                                $(function() {
                                    $('#language_dropdown').select2({
                                        placeholder: 'Select an option'
                                    });
                                });
                            </script>
                            @endpush



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
