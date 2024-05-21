@extends('layouts.master')

@section('title')
    @lang('translation.languages.languages')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.languages.languages')
        @endslot
    @endcomponent

    {{-- Add Button --}}
    <div class="row d-flex justify-content-end mb-3 mt-1">
        <div class="col-auto">
            <a href="{{route('languages.create')}}" type="button" class="btn btn-success waves-effect waves-light me-2">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.languages.addLanguage')
            </a>
        </div>
    </div>
    <br>




    {{-- Table --}}
    <h5 class="mb-3 ">@lang('translation.languages.languages')</h5>
    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.languages.language')</th>
			<th>@lang('translation.fields.action')</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@endsection


@section('script')
    <script type="text/javascript">
        $(function() {
            var columns = [
                {
                    data: 'DT_RowIndex',
                    name: 'No',
                    searchable: false,
                    orderable: false,
                    search: {
                        'type': 'disabled'
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    search: {
                        'type': 'text'
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    search: {
                        'type': 'disabled'
                    }
                },
            ];
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                ajax: "{{ route('languages.index') }}",
                lengthMenu: [
                    [100, 250, 500],
                    [100, 250, 500]
                ],
                columns: columns,
                initComplete: function () {
                    buildDtColumns(this.api(), columns);
                }
            });
        });
    </script>
@endsection
