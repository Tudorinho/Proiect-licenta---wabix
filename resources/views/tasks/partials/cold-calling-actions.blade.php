<button style="float: left; margin: 2px;" class="edit btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#task_cold_calling_actions{{ $task->id }}">
    <i class="fas fa-phone-alt"></i>
</button>
<div id="task_cold_calling_actions{{ $task->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Cold Emailing Actions {{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">@lang('translation.fields.quickActions')</label>

                <div class="row">
                    <div class="col-6">
                        <form action="{{ route('tasks.cold-calling-quick-actions', ['id' => $task->id]) }}" method="POST">
                            <div>
                                {{ csrf_field() }}
                                <input type="hidden" name="cold_calling_status" value="bad_phone_no">
                                <button style="width: 100%;" type="submit" class="btn btn-danger w-md">@lang('translation.buttons.badPhoneNo')</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-6">
                        <form action="{{ route('tasks.cold-calling-quick-actions', ['id' => $task->id]) }}" method="POST">
                            <div>
                                {{ csrf_field() }}
                                <input type="hidden" name="cold_calling_status" value="not_interested">
                                <button style="width: 100%;" type="submit" class="btn btn-warning w-md">@lang('translation.buttons.notInterested')</button>
                            </div>
                        </form>
                    </div>

{{--                    <div class="col-6 mt-3">--}}
{{--                        <form action="{{ route('tasks.cold-calling-quick-actions', ['id' => $task->id]) }}" method="POST">--}}
{{--                            <div>--}}
{{--                                {{ csrf_field() }}--}}
{{--                                <input type="hidden" name="cold_calling_status" value="interested">--}}
{{--                                <button style="width: 100%;" type="submit" class="btn btn-primary w-md">@lang('translation.buttons.interested')</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
