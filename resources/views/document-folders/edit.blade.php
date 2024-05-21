@extends('layouts.master')

@section('title')
    @lang('translation.documentFolders.editFolder')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('document-folders.index') }}">@lang('translation.documentFolders.documentFolders')</a>
        @endslot
        @slot('title')
            @lang('translation.documentFolders.editFolder')
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
                    <form action="{{ route('document-folders.update', ['id'=>$folder->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">

                            {{-- document_folder_id --}}
                            <input type="hidden" name="document_folder_id" value="{{ $folder->document_folder_id }}">

                            {{-- name --}}
                            <div class="col-6">
                                <label class="form-label">@lang('translation.documentFolders.folderName')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.documentFolders.folderName')" value="{{ old('name', $folder?->name ?? '') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>


                            {{-- Assign Permissions --}}
                            <div class="col-6">
                                <label class="form-label">@lang('translation.documentFolders.assignPermissions')</label>
                                <select class="form-control" name="user_permissions[]" id="permissions_dropdown" multiple>
                                    <option value="">@lang('translation.documentFolders.selectLanguage')</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->user->id }}" {{ $folder->permissions->contains('user_id', $employee->user->id) ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                                @if(!empty($errors->first('user_permissions')))
                                    <div class="invalid-feedback">{{ $errors->first('user_permissions') }}</div>
                                @endif
                            </div>

                            @push('scripts')
                            <script>
                                $(function() {
                                    $('#permissions_dropdown').select2({
                                        placeholder: 'Select an option',
                                        multiple: true
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
