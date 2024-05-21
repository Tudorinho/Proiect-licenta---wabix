<button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#import_list" style="float: right; margin-left: 5px;">
    <i class="bx bx-plus font-size-16 align-middle me-2"></i> @lang('translation.buttons.importList')
</button>
<div id="import_list" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Contacts Into Cold Calling List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label alert alert-warning">CSV Files are accepted only and it should have header line as well. The following structure is needed: index, cui, name, county, caen, employees_count, income, url, phone, website, email, status and comment.</label>
                <label class="form-label alert alert-warning">Tasks are created automatically if contact has a phone number attached.</label>

                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('cold-calling-lists-contacts.import-contacts') }}" method="POST" enctype="multipart/form-data">
                            <div>
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">@lang('translation.fields.importFile')</label>
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label class="form-label">@lang('translation.fields.coldCallingListsId')</label>
                                        <select class="form-control" name="cold_calling_lists_id" id="cold_calling_lists_id_dropdown">
                                            @foreach($coldCallingLists as $value)
                                                <option value="{{ $value->id }}" {{ (old('cold_calling_lists_id') == $value->id || (isset($model) && $model->cold_calling_lists_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label class="form-label">@lang('translation.fields.currencyId')</label>
                                        <select class="form-control" name="currency_id" id="currency_id_dropdown" required>
                                            @foreach($currencies as $value)
                                                <option value="{{ $value->id }}" {{ (old('currency_id') == $value->id || (isset($deal) && $deal->currency_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

{{--                                    <div class="col-6 mt-3">--}}
{{--                                        <div class="form-check form-switch form-switch-lg">--}}
{{--                                            <input class="form-check-input" type="checkbox" checked="checked" name="create_task">--}}
{{--                                            <label class="form-check-label">@lang('translation.fields.createTasks')</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>

                                <button style="width: 100%;" type="submit" class="mt-3 btn btn-success w-md">@lang('translation.buttons.import')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
