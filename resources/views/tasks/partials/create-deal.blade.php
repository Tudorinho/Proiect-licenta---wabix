<button style="float: left; margin: 2px;" class="edit btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#task_create_deal_{{ $task->id }}">
    <i class="fas fa-envelope-open-text"></i>
</button>
<div id="task_create_deal_{{ $task->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create deal for {{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label alert alert-warning">Once you create a deal from this task, task will be marked as done, cold calling will be marked as interested and email thread will be associated to the deal.</label>

                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('tasks.create-deal', ['id' => $task->id]) }}" method="POST">
                            <div>
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label">@lang('translation.fields.dealsSourcesId')</label>
                                        <select class="form-control" name="deals_sources_id" id="deals_sources_id_dropdown" required>
                                            @foreach($dealsSources as $value)
                                                <option value="{{ $value->id }}" {{ (old('deals_sources_id') == $value->id || (isset($deal) && $deal->deals_sources_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">@lang('translation.fields.dealSize')</label>
                                        <input type="number" step="any" class="form-control" name="deal_size" placeholder="@lang('translation.fields.dealSize')" value="0" required>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">@lang('translation.fields.currencyId')</label>
                                        <select class="form-control" name="currency_id" id="currency_id_dropdown" required>
                                            @foreach($currencies as $value)
                                                <option value="{{ $value->id }}" {{ (old('currency_id') == $value->id || (isset($deal) && $deal->currency_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button style="width: 100%;" type="submit" class="mt-3 btn btn-success w-md">@lang('translation.buttons.createDeal')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
