<button style="float: right; margin-right: 5px;" class="edit btn btn-primary btn-sm deal_edit"
        data-bs-toggle="modal"
        data-bs-target="#deal_edit_{{ $deal->id }}">
    <i class="fas fa-pen"></i>
</button>
<div id="deal_edit_{{ $deal->id }}" class="modal modal-xl fade" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Deal {{ $deal->title }} Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="task_thread_messages_modal_body_{{ $deal->id }}">
                <div class="card">
                    <form action="{{ route('deals.update', ['id' => $deal->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
                        <h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

                        <div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.userId')</label>
                                <select class="form-control" name="user_id" id="user_id_dropdown">
                                    @foreach($users as $value)
                                        <option value="{{ $value->id }}" {{ (old('user_id') == $value->id || (isset($deal) && $deal->user_id == $value->id)) ? 'selected' : '' }}>{{ $value->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.companiesContactsId')</label>
                                <select class="form-control" name="companies_contacts_id" id="companies_contacts_id_dropdown_{{ $deal->id }}">
                                    <?php
                                        $companiesContacts = \App\Models\CompanyContact::where([
                                            'id' => $deal->companies_contacts_id
                                        ])->get();
                                    ?>
                                    @foreach($companiesContacts as $value)
                                        <option value="{{ $value->id }}" {{ (old('companies_contacts_id') == $value->id || (isset($deal) && $deal->companies_contacts_id == $value->id)) ? 'selected' : '' }}>{{ $value->first_name.' '.$value->last_name.'('.$value->company->name.')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#companies_contacts_id_dropdown_{{ $deal->id }}').select2({
                                            placeholder: 'Select an option',
                                            dropdownParent: $("#deal_edit_{{ $deal->id }}"),
                                            ajax: {
                                                url: '{{ route('companies-contacts.quick-search') }}',
                                                delay: 250,
                                                data: function (params) {
                                                    var query = {
                                                        keyword: params.term,
                                                        deal_id: "{{ $deal->id }}"
                                                    }

                                                    return query;
                                                },
                                                processResults: function (data) {
                                                    return {
                                                        results: $.map(data.results, function (item) {
                                                            return {
                                                                text: item.text,
                                                                id: item.id
                                                            }
                                                        })
                                                    };
                                                }
                                            }
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.dealsStatusesId')</label>
                                <select class="form-control" name="deals_statuses_id" id="deals_statuses_id_dropdown">
                                    @foreach($dealsStatuses as $value)
                                        <option value="{{ $value->id }}" {{ (old('deals_statuses_id') == $value->id || (isset($deal) && $deal->deals_statuses_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.dealsSourcesId')</label>
                                <select class="form-control" name="deals_sources_id" id="deals_sources_id_dropdown">
                                    @foreach($dealsSources as $value)
                                        <option value="{{ $value->id }}" {{ (old('deals_sources_id') == $value->id || (isset($deal) && $deal->deals_sources_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 mt-3">
                                <label class="form-label">@lang('translation.fields.dealSize')</label>
                                <input type="text" class="form-control" name="deal_size" placeholder="@lang('translation.fields.dealSize')" value="{{ old('deal_size', $deal?->deal_size ?? '') }}">
                            </div>
                            <div class="col-2 mt-3">
                                <label class="form-label">@lang('translation.fields.currencyId')</label>
                                <select class="form-control" name="currency_id" id="currency_id_dropdown">
                                    @foreach($currencies as $value)
                                        <option value="{{ $value->id }}" {{ (old('currency_id') == $value->id || (isset($deal) && $deal->currency_id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 mt-3">
                                <label class="form-label">@lang('translation.fields.type')</label>
                                <select class="form-control" name="type" id="type_dropdown">
                                    @foreach($types as $value)
                                        <option value="{{ $value }}" {{ (old('type') == $value || (isset($deal) && $deal->type == $value)) ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">@lang('translation.fields.title')</label>
                                <input type="text" class="form-control" name="title" placeholder="@lang('translation.fields.title')" value="{{ old('title', $deal?->title ?? '') }}">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.description')</label>
                                <textarea  style="resize: none; height: 250px;" class="form-control" name="description" placeholder="@lang('translation.fields.description')">{{ old('description', $deal?->description ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary w-md">@lang('translation.buttons.submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
