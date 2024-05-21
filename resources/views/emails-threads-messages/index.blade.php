@extends('layouts.master')

@section('title')
    @lang('translation.emailThreadMessage.emailsThreadsMessages')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.menu.dashboard')
        @endslot
        @slot('title')
            @lang('translation.emailThreadMessage.emailsThreadsMessages')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('emails-threads-messages.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
			<th>@lang('translation.fields.no')</th>
			<th>@lang('translation.fields.subject')</th>
			<th>@lang('translation.fields.date')</th>
			<th>@lang('translation.fields.from')</th>
			<th>@lang('translation.fields.to')</th>
			<th>@lang('translation.fields.emailsThreadsId')</th>
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
                        'type': 'disabled',
                    }
                },
                {
                    data: 'subject',
                    name: 'subject',
                },
                {
                    data: 'date',
                    name: 'date',
                },
                {
                    data: 'from',
                    name: 'from',
                },
                {
                    data: 'to',
                    name: 'to',
                },
                {
                    data: 'emails_threads_id',
                    name: 'emails_threads_id',
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                    search: {
                        'type': 'disabled',
                    }
                },
            ];

            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('emails-threads-messages.index') }}",
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
