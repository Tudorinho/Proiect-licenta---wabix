@extends('layouts.master')

@section('title')
    @lang('translation.documentFolders.documentFolders')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.documentFolders.documentFolders')
        @endslot
        @slot('extrabreadcrumb')
            @foreach ($breadcrumbs as $crumb)
                        <li class="breadcrumb-item">
                            @if ($crumb->id == $currentFolder->id)
                                {{ $crumb->name }}
                            @else
                                <a href="{{ route('document-folders.index', ['document_folder_id' => $crumb->id]) }}">
                                    {{ $crumb->name }}
                                </a>
                            @endif
                        </li>
            @endforeach
        @endslot
    @endcomponent


    @if($isAdmin)
        {{-- Buttons --}}
        <div class="row d-flex justify-content-end mb-3 mt-1">
            <div class="col-auto">
                <a href="{{route('document-folders.create')}}?document_folder_id={{request()->input('document_folder_id')}}" type="button" class="btn btn-success waves-effect waves-light me-2">
                    <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.documentFolders.addFolder')
                </a>
                <a href="{{route('document-folders.create-file')}}?document_folder_id={{request()->input('document_folder_id')}}" type="button" class="btn btn-success waves-effect waves-light">
                    <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.documentFolders.addFile')
                </a>
            </div>
        </div>
        <br>
    @endif




    {{-- Folders Section --}}
    <h5 class="mb-1">@lang('translation.documentFolders.Folders')</h5>
    <div class="row">
        @foreach ($folders as $folder)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-1">
                <div class="d-flex align-items-center">

                    {{-- Icon and Name --}}
                    <a href="{{route('document-folders.index')}}?document_folder_id={{$folder->id}}" class="d-flex align-items-center folder-item">
                        <i class="fas fa-folder fa-3x"></i>
                        <span class="ms-2 fw-bold">{{ $folder->name }}</span>
                        <span class="bg-success fw-bold text-white mb-4 ms-1 rounded-pill p-6">
                                @if($folder->permissions->count() > 0)
                                    {{ $folder->permissions->count() }}
                                @else
                                    ALL
                                @endif
                        </span>

                    </a>

                    @if($isAdmin)
                        {{-- Edit --}}
                        <a href="{{route('document-folders.edit', ['id'=>$folder->id])}}" type="button" class="edit btn btn-info btn-sm ms-4">
                            <i class="fas fa-pencil-alt"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('document-folders.destroy', ['id' => $folder->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm ms-2">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        @endforeach
    </div>


    {{-- Files Section --}}
    <h5 class="mb-2 mt-3">@lang('translation.documentFolders.Files')</h5>
    <div class="d-flex flex-column justify-content-between" style="height: 40vh">
        <div class="row">
            @foreach ($files as $file)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                    <div class="d-flex justify-center align-items-center">

                        {{-- Icon and Name --}}
                        <a target="_blank" href="{{$file->data}}" class="d-flex align-items-center folder-item">
                            <i class="fas fa-file fa-3x"></i>
                            <span class="ms-2 fw-bold">{{ $file->name }}</span>
                        </a>

                        {{-- Language --}}
                        <div class="badge bg-primary ms-1" style="cursor: pointer" title="{{ $file->language->name }}">
                            @php
                                $languageName = strtoupper(substr($file->language->name, 0, 2));
                            @endphp
                            <span class="hover-text" data-name="{{ $file->language->name }}">{{ $languageName }}</span>
                        </div>

                        @if($isAdmin)
                            {{-- Edit --}}
                            <a href="{{route('document-folders.edit-file', ['id'=>$file->id])}}" type="button" class="edit btn btn-info btn-sm ms-4">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('document-folders.destroy-file', ['id' => $file->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm ms-2">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-3">
            {!! $files->links() !!}
        </div>

    </div>




@endsection





