<div class="offcanvas offcanvas-end" tabindex="-1" id="project_actions_canvas_{{ $row->id }}">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">{{ $row->name }} Actions</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-header pt-0 pb-0">
        <div class="col-12">
            <button style="width: 100%" type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#add_project_action_{{ $row->id }}">Add Action</button>
        </div>
    </div>

    <div id="add_project_action_{{ $row->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Action for {{ $row->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.add-action', ['id'=> $row->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="view" value="{{ isset($_GET['view']) ? $_GET['view'] : '' }}">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">@lang('translation.fields.description')</label>
                                <textarea style="height: 250px; resize: none;" class="form-control" name="description" placeholder="@lang('translation.fields.description')"></textarea>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">@lang('translation.fields.status')</label>
                                <select name="status" class="form-control">
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">@lang('translation.fields.dueDate')</label>
                                <input type="text" id="project_action_datepicker_{{ $row->id }}" class="form-control" name="due_date" placeholder="@lang('translation.fields.dueDate')">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-md">@lang('translation.buttons.submit')</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="offcanvas-body">
        @foreach($row->projectActions()->orderBy('due_date', 'asc')->get() as $projectAction)
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <p>{{ $projectAction->description }}</p>
                        <div class="row">
                            <div class="col-6"><small class="text-muted">Due Date: {{ (new DateTime($projectAction->due_date))->format('Y-m-d') }}</small></div>
                            <div class="col-6">
                                <form action="{{ route('projects.update-action-status', ['id' => $row->id, 'actionId' => $projectAction->id]) }}" method="POST">
                                    @method('PUT')
                                    {{ csrf_field() }}
                                    <select name="status" class="form-control project_action_select">
                                        <option value="not_started" @selected($projectAction->status == 'not_started')>Not Started</option>
                                        <option value="in_progress" @selected($projectAction->status == 'in_progress')>In Progress</option>
                                        <option value="done" @selected($projectAction->status == 'done')>Done</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .modal-backdrop{
        display: none !important;
    }

    .datepicker-container{
        z-index: 99999999 !important;
    }
</style>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#project_action_datepicker_{{ $row->id }}').datepicker({
                "format": "yyyy-mm-dd"
            });

            $('.project_action_select').change(function(){
                $(this).parent().submit();
            });
        })
    </script>
@endpush
