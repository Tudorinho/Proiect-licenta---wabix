@extends('layouts.master')

@section('title')
    @lang('translation.companyContact.companiesContacts')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.companyContact.companiesContacts')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('companies-contacts.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.firstName')</th>
			<th>@lang('translation.fields.lastName')</th>
			<th>@lang('translation.fields.email')</th>
			<th>@lang('translation.fields.position')</th>
			<th>@lang('translation.fields.company')</th>
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
                    data: 'first_name',
                    name: 'first_name',
                    search: {
                        'type': 'text'
                    }
                },
                {
                    data: 'last_name',
                    name: 'last_name',
                    search: {
                        'type': 'text'
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    search: {
                        'type': 'text'
                    }
                },
                {
                    data: 'position',
                    name: 'position',
                    search: {
                        'type': 'text'
                    }
                },
                {
                    data: 'company',
                    name: 'company_id',
                    search: {
                        'type': 'dropdown',
                        'url': '{{ route('companies.quick-search') }}'
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
                ajax: "{{ route('companies-contacts.index') }}",
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
