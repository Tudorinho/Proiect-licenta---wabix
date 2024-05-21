@extends('layouts.master')

@section('title')
    @lang('translation.leave.leaves')
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
            @lang('translation.leave.leaves')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('leaves.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
            <a href="{{ route('leaves.calendar') }}" type="button" class="btn btn-info waves-effect waves-light" style="float: right; margin-left: 5px;">Calendar View</a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.employeeId')</th>
			<th>@lang('translation.fields.leaveTypeId')</th>
			<th>@lang('translation.fields.startDate')</th>
			<th>@lang('translation.fields.endDate')</th>
			<th>@lang('translation.fields.status')</th>
			<th>@lang('translation.fields.leaveDays')</th>
			<th>@lang('translation.fields.holidayDays')</th>
			<th>@lang('translation.fields.weekendDays')</th>
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
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('leaves.index') }}",
                lengthMenu: [
                    [100, 250, 500],
                    [100, 250, 500]
                ],
                columns: [
					{
						data: 'DT_RowIndex',
						name: 'No',
						searchable: false,
					},
					{
						data: 'employee_id',
						name: 'employee_id',
					},
					{
						data: 'leave_type_id',
						name: 'leave_type_id',
					},
					{
						data: 'start_date',
						name: 'start_date',
					},
					{
						data: 'end_date',
						name: 'end_date',
					},
					{
						data: 'status',
						name: 'status',
					},
                    {
                        data: 'leave_days',
                        name: 'leave_days',
                    },
                    {
                        data: 'holiday_days',
                        name: 'holiday_days',
                    },
                    {
                        data: 'weekend_days',
                        name: 'weekend_days',
                    },
					{
						data: 'action',
						name: 'action',
					},
                ],
                initComplete: function () {
                    var tr = document.createElement('tr');

                    this.api()
                        .columns()
                        .every(function () {
                            let column = this;
                            let title = column.header().innerHTML;

                            var th = document.createElement('th');
                            th.style.paddingLeft = '10px';
                            th.style.paddingRight = '10px';

                            let input = document.createElement('input');
                            input.placeholder = title;
                            input.style.width = '100%';

                            input.addEventListener('keyup', () => {
                                if (column.search() !== this.value) {
                                    column.search(input.value).draw();
                                }
                            });

                            th.append(input);
                            tr.append(th);
                        });

                    $('#smart-datatable').children('thead').append(tr);
                }
            });
        });
    </script>
@endsection
