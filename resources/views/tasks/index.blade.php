@extends('layouts.master')

@section('title')
    @lang('translation.task.tasks')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.task.tasks')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('tasks.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable overflow-x-scroll" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.title')</th>
			{{-- <th>@lang('translation.fields.description')</th> --}}
			<th>@lang('translation.fields.status')</th>
			<th>@lang('translation.fields.priority')</th>
			<th>@lang('translation.fields.dueDate')</th>
			<th>@lang('translation.fields.userId')</th>
			<th>@lang('translation.fields.tasksListsId')</th>
			<th>@lang('translation.fields.estimate')</th>
			<th>@lang('translation.fields.action')</th>
        </tr>
        </thead>
        <tbody class="overflow-x-scroll">
        </tbody>
    </table>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tasks.index') }}",
                lengthMenu: [
                    [10, 100, 500],
                    [10, 100, 500]
                ],
                columns: [
					{
						data: 'DT_RowIndex',
						name: 'No',
						searchable: false,
					},
					{
						data: 'title',
						name: 'title',
					},
					{
						data: 'status',
						name: 'status',
					},
					{
						data: 'priority',
						name: 'priority',
					},
					{
						data: 'due_date',
						name: 'due_date',
					},
					{
						data: 'user_id',
						name: 'user_id',
					},
					{
						data: 'tasks_lists_id',
						name: 'tasks_lists_id',
					},
                    {
                        data: 'estimate',
                        name: 'estimate',
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
