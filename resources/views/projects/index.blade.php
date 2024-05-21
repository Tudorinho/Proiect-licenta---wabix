@extends('layouts.master')

@section('title')
    @lang('translation.project.projects')
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
            @lang('translation.project.projects')
        @endslot
    @endcomponent

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('projects.create') }}" type="button" class="btn btn-success waves-effect waves-light" style="float: right; margin-left: 5px;">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
            <a href="{{ route('projects.index', ['view' => 'kanban']) }}" type="button" class="btn btn-info waves-effect waves-light" style="float: right; margin-left: 5px;">Kanban View</a>
        </div>
    </div>

    <table class="table table-bordered smart-datatable" id="smart-datatable">
        <thead>
        <tr>
            <th>@lang('translation.fields.no')</th>
            <th>@lang('translation.fields.priority')</th>
            <th>@lang('translation.fields.name')</th>
            <th>@lang('translation.fields.status')</th>
            <th>@lang('translation.fields.contractType')</th>
            <th>@lang('translation.fields.projectSource')</th>
            <th>@lang('translation.fields.actionsNeeded')</th>
            <th>@lang('translation.fields.actions')</th>
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
        $(document).ready(function(){
            setTimeout(function(){
                var actions = '{{ $actions }}';
                if(actions){
                    var myOffcanvas = document.getElementById('project_actions_canvas_'+actions);
                    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
                    bsOffcanvas.show();
                }
            }, 300);

            setTimeout(function(){
                var documents = '{{ $documents }}';
                if(documents){
                    var myOffcanvas = document.getElementById('documents_canvas_'+documents);
                    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
                    bsOffcanvas.show();
                }
            }, 300);
        })

        $(function() {
            var table = $('.smart-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('projects.index') }}",
                lengthMenu: [
                    [100, 250, 500],
                    [100, 250, 500]
                ],
                order: [[6, 'asc']],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'No',
                        searchable: false
                    },
                    {
                        data: 'project_priority_id',
                        name: 'project_priority_id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'project_status_id',
                        name: 'project_status_id',
                    },
                    {
                        data: 'project_contract_type_id',
                        name: 'project_contract_type_id',
                    },
                    {
                        data: 'project_source_id',
                        name: 'project_source_id',
                    },
                    {
                        data: 'actions_needed',
                        name: 'actions_needed',
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
