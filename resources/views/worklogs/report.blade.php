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
            @lang('translation.worklog.worklogsReport')
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-2">
                        <select class="form-control" name="project_id" id="project_id_dropdown">
                            <option></option>
                            @foreach($projects as $value)
                                <option value="{{ $value->id }}" {{ ($project_id == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#project_id_dropdown').select2({
                                    placeholder: 'Select a project...'
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <select class="form-control" name="employee_id" id="employee_id_dropdown">
                            <option></option>
                            @foreach($employees as $value)
                                <option value="{{ $value->id }}" {{ ($employee_id == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->first_name.' '.$value->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#employee_id_dropdown').select2({
                                    placeholder: 'Select an employee...'
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <input type="text" class="form-control" id="start_date_datepicker" name="start_date" placeholder="@lang('translation.fields.startDate')" value="{{ $start_date }}">
                        @if(!empty($errors->first('start_date')))
                            <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                        @endif
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#start_date_datepicker').datepicker({
                                    "format": "yyyy-mm-dd"
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <input type="text" class="form-control" id="end_date_datepicker" name="end_date" placeholder="@lang('translation.fields.endDate')" value="{{ $end_date }}">
                        @if(!empty($errors->first('end_date')))
                            <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                        @endif
                    </div>
                    @push('scripts')
                        <script>
                            $(function() {
                                $('#end_date_datepicker').datepicker({
                                    "format": "yyyy-mm-dd"
                                });
                            });
                        </script>
                    @endpush

                    <div class="col-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('worklogs.report').'?start_date='.\Carbon\Carbon::now()->subDay()->format('Y-m-d') }}" class="btn btn-danger">
                            <i class="fas fa-circle-notch"></i>
                        </a>

                        <a href="{{ url()->full().'&download=1' }}" class="btn btn-warning">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <h5>@lang('translation.headings.generalInformation')</h5>
                <table class="table table-striped">
                    <tr>
                        <th>@lang('translation.fields.employeeId')</th>
                        <th>@lang('translation.fields.projectId')</th>
                        <th>@lang('translation.fields.hours')</th>
                        <th>@lang('translation.fields.date')</th>
                        <th>@lang('translation.fields.description')</th>
                    </tr>
                    @foreach($worklogs as $worklog)
                        <tr>
                            <td>{{ $worklog->employee->first_name.' '.$worklog->employee->last_name }}</td>
                            <td>{{ $worklog->project->name }}</td>
                            <td>{{ $worklog->hours }}</td>
                            <td>{{ $worklog->date }}</td>
                            <td>{{ $worklog->description }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <h5>@lang('translation.headings.totals')</h5>
                <table class="table table-striped">
                    <tr>
                        <th>@lang('translation.fields.employeeId')</th>
                        <th>@lang('translation.fields.projectId')</th>
                        <th>@lang('translation.fields.hours')</th>
                    </tr>
                    @foreach($totals as $employeeName => $projects)
                        @foreach($projects as $projectName => $hours)
                            <tr>
                                <td>{{ $employeeName }}</td>
                                <td>{{ $projectName }}</td>
                                <td>{{ $hours }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- toastr -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">

    </script>
@endsection
