
@extends('layouts.master')

@section('title')
    @lang('translation.company.companies')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.company.companies')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('companies.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.name')</th>
			<th>@lang('translation.fields.registrationNumber')</th>
			<th>@lang('translation.fields.type')</th>
			<th>@lang('translation.fields.createdAt')</th>
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
                        type: 'disabled'
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'registration_number',
                    name: 'registration_number',
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    search: {
                        'type': 'disabled'
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                    search: {
                        type: 'disabled'
                    }
                },
            ];

            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                ajax: "{{ route('companies.index') }}",
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
