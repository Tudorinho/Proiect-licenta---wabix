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
        <div class="col-1">
            <a href="{{ route('projects.create') }}" type="button" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.add')
            </a>
        </div>
        <div class="col-9">
        </div>
        <div class="col-2" style="text-align: right;">
            <a href="{{ route('projects.index') }}" type="button" class="btn btn-info waves-effect waves-light">List View</a>
        </div>
    </div>

    <div class="" style="display: flex; overflow: scroll">
        @foreach($projectStatuses as $projectStatusName => $projectStatusColor)
            <div class="" style="float: left; min-width: 350px; margin-right: 20px;">
                <div class="card">
                    <div class="card-header" style="font-size: 12px; text-align: center; color: {{ $projectStatusColor }}; border: 1.5px solid {{ $projectStatusColor }}">{{ $projectStatusName }}</div>
                </div>
                <?php $data = $projects[$projectStatusName]; ?>
                @foreach($data as $project)
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless table-striped">
                            <tr>
                                <td>Name</td>
                                <td style="font-weight: bold;">{{ $project->name }}</td>
                            </tr>
                            <tr>
                                <td>Source</td>
                                <td>{{ $project->projectSource->name }}</td>
                            </tr>
                            <tr>
                                <td>Priority</td>
                                <td>
                                    @include('components.columns.label', ['text' => $project->projectPriority->name, 'color' => $project->projectPriority->color])
                                </td>
                            </tr>
                            <tr>
                                <td>Contract Type</td>
                                <td>
                                    @include('components.columns.label', ['text' => $project->projectContractType->name, 'color' => $project->projectContractType->color])
                                </td>
                            </tr>
                            <tr>
                                <td>Next Actions</td>
                                <td>
                                    @include('components.columns.actions-needed', [
                                        'notStarted' => $project->projectActions()->where(['status' => 'not_started'])->count(),
                                        'inProgress' => $project->projectActions()->where(['status' => 'in_progress'])->count(),
                                        'nextDueDate' => $project->projectActions()->whereIn('status', ['not_started', 'in_progress'])->orderBy('due_date', 'asc')->first()
                                    ])
                                </td>
                            </tr>
                            <tr>
                                <td>Actions</td>
                                <td>
                                    @include('components.columns.actions', [
                                      'row' => $project,
                                      'edit' => 'projects.edit',
                                      'destroy' => 'projects.destroy',
                                      'projectActions' => true,
                                      'documents' => true
                                    ])
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>

@endsection
@section('script')
    <script>
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
    </script>
@endsection
