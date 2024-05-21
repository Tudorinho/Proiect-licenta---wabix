@extends('layouts.master')

@section('title')
    @lang('translation.worklog.worklogs')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.worklog.worklogs')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('worklogs.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.hours')</th>
			<th>@lang('translation.fields.employeeId')</th>
			<th>@lang('translation.fields.projectId')</th>
			<th>@lang('translation.fields.description')</th>
			<th>@lang('translation.fields.date')</th>
			<th>@lang('translation.fields.action')</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@section('script')
    <!-- toastr -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var columns = [
                {
                    data: 'DT_RowIndex',
                    name: 'No',
                    searchable: false,
                    orderable: false,
                    search: {
                        'type': 'disabled',
                    }
                },
                {
                    data: 'hours',
                    name: 'hours',
                },
                {
                    data: 'employee',
                    name: 'employee_id',
                    search: {
                        'type': 'dropdown',
                        'url': '{{ route('employees.quick-search') }}',
                        'default': {
                            'value': '{{\Illuminate\Support\Facades\Auth::user()->employee->id}}',
                            'text': '{{\Illuminate\Support\Facades\Auth::user()->employee->first_name}}'
                        }
                    }
                },
                {
                    data: 'project',
                    name: 'project_id',
                    search: {
                        'type': 'dropdown',
                        'url': '{{ route('projects.quick-search') }}'
                    }
                },
                {
                    data: 'description',
                    name: 'description',
                },
                {
                    data: 'date',
                    name: 'date',
                    searchable: false,
                    search: {
                        'type': 'daterange'
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    search: {
                        'type': 'disabled',
                    }
                },
            ];

            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                order: [],
                ajax: "{{ route('worklogs.index') }}",
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
