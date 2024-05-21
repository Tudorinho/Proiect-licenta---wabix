@extends('layouts.master')

@section('title')
    @lang('translation.coldEmailingRules.coldEmailingRules')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.coldEmailingRules.coldEmailingRules')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('cold-emailing-rules.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.name')</th>
			<th>@lang('translation.fields.coldEmailingCredentialsId')</th>
			<th>@lang('translation.fields.subject')</th>
			<th>@lang('translation.fields.lastCheckDate')</th>
			<th>@lang('translation.fields.tasksListsId')</th>
			<th>@lang('translation.fields.userId')</th>
			<th>@lang('translation.fields.lastError')</th>
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
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('cold-emailing-rules.index') }}",
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
						data: 'name',
						name: 'name',
					},
					{
						data: 'cold_emailing_credentials_id',
						name: 'cold_emailing_credentials_id',
					},
					{
						data: 'subject',
						name: 'subject',
					},
					{
						data: 'last_check_date',
						name: 'last_check_date',
					},
					{
						data: 'tasks_lists_id',
						name: 'tasks_lists_id',
					},
                    {
                        data: 'user_id',
                        name: 'user_id',
                    },
                    {
                        data: 'last_error',
                        name: 'last_error',
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
