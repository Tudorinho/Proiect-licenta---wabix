<div class="card">
        <form>
            <input type="hidden" name="id" value="{{ $companyContact->id }}">
            {{ csrf_field() }}
            <h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

            <div class="row">
                <div class="col-3 ">
                    <label class="form-label">@lang('translation.fields.firstName')</label>
                    <input type="text" class="form-control" name="first_name" placeholder="@lang('translation.fields.firstName')" value="{{ old('first_name', $companyContact?->first_name ?? '') }}">
                    @if(!empty($errors->first('first_name')))
                        <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                    @endif
                </div>
                <div class="col-3 ">
                    <label class="form-label">@lang('translation.fields.lastName')</label>
                    <input type="text" class="form-control" name="last_name" placeholder="@lang('translation.fields.lastName')" value="{{ old('last_name', $companyContact?->last_name ?? '') }}">
                    @if(!empty($errors->first('last_name')))
                        <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                    @endif
                </div>
                <div class="col-3 ">
                    <label class="form-label">@lang('translation.fields.position')</label>
                    <input type="text" class="form-control" name="position" placeholder="@lang('translation.fields.position')" value="{{ old('position', $companyContact?->position ?? '') }}">
                    @if(!empty($errors->first('position')))
                        <div class="invalid-feedback">{{ $errors->first('position') }}</div>
                    @endif
                </div>
                <div class="col-3 ">
                    <label class="form-label">@lang('translation.fields.email')</label>
                    <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ old('email', $companyContact?->email ?? '') }}">
                    @if(!empty($errors->first('email')))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col-3 mt-3">
                    <label class="form-label">@lang('translation.fields.companyId')</label>
                    <input type="text" class="form-control" name="email" placeholder="@lang('translation.fields.email')" value="{{ $companyContact->company->name }}" disabled>
                    @if($errors->has('company_id'))
                        <div class="invalid-feedback">{{ $errors->first('company_id') }}</div>
                    @endif
                </div>
                <div class="col-3 mt-3">
                    <label class="form-label">@lang('translation.fields.phone')</label>
                    <input type="text" class="form-control" name="phone" placeholder="@lang('translation.fields.phone')" value="{{ old('phone', $companyContact?->phone ?? '') }}">
                    @if(!empty($errors->first('phone')))
                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary w-md task_contact_information_submit">@lang('translation.buttons.submit')</button>
            </div>
        </form>
</div>
