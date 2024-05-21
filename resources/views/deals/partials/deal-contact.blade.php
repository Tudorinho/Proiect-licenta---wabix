<button style="float: right; margin-right: 5px;" class="edit btn btn-dark btn-sm deal_contact"
        data-bs-toggle="modal"
        data-bs-target="#deal_contact_{{ $deal->id }}">
    <i class="fas fa-user"></i>
</button>
<div id="deal_contact_{{ $deal->id }}" class="modal modal-xl fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Deal {{ $deal->title }} Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 300px;overflow-y: scroll;"  id="deal_contact_{{ $deal->id }}">
                <div class="card">
                    <form action="{{ route('companies-contacts.update', ['id' => $deal->companyContact->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
                        <h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

                        <div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.firstName')</label>
                                <input type="text" class="form-control" name="first_name" placeholder="@lang('translation.fields.firstName')" value="{{ old('first_name', $deal->companyContact?->first_name ?? '') }}">
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.lastName')</label>
                                <input type="text" class="form-control" name="last_name" placeholder="@lang('translation.fields.lastName')" value="{{ old('last_name', $deal->companyContact?->last_name ?? '') }}">
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.position')</label>
                                <input type="text" class="form-control" name="position" placeholder="@lang('translation.fields.position')" value="{{ old('position', $deal->companyContact?->position ?? '') }}">
                            </div>
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.email')</label>
                                <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ old('email', $deal->companyContact?->email ?? '') }}">
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.companyId')</label>
                                <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ $deal->companyContact->company->name }}" disabled>
                            </div>
                            <div class="col-3 mt-3">
                                <label class="form-label">@lang('translation.fields.phone')</label>
                                <input type="text" class="form-control" name="phone" placeholder="@lang('translation.fields.phone')" value="{{ old('phone', $deal->companyContact?->phone ?? '') }}">
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
