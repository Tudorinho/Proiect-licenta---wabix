@extends('layouts.master')

@section('title')
    @lang('translation.coldEmailingCredentials.coldEmailingCredentials')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.coldEmailingCredentials.coldEmailingCredentials')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('cold-emailing-credentials.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.email')</th>
			<th>@lang('translation.fields.username')</th>
			<th>@lang('translation.fields.validated')</th>
			<th>@lang('translation.fields.lastError')</th>
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
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('cold-emailing-credentials.index') }}",
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
						data: 'email',
						name: 'email',
					},
					{
						data: 'username',
						name: 'username',
					},
					{
						data: 'validated',
						name: 'validated',
					},
					{
						data: 'last_error',
						name: 'last_error',
					},
					{
						data: 'created_at',
						name: 'created_at',
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
