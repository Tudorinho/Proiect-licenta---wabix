@extends('layouts.master')

@section('title')
    @lang('translation.leaveBalance.addLeaveBalance')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('leaves-balances.index') }}">@lang('translation.leaveBalance.leavesBalances')</a>
        @endslot
        @slot('title')
            @lang('translation.leaveBalance.addLeaveBalance')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            @if($errors->any())
               <div class="col-12 alert alert-danger">
                   {!! implode('', $errors->all('<div>:message</div>')) !!}
               </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leaves-balances.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.employeeId')</label>
                                <select class="form-control" name="employee_id" id="employee_id_dropdown">
                                    @foreach($employees as $value)
                                        <option value="{{ $value->id }}" {{ (old('employee_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->first_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee_id'))
                                    <div class="invalid-feedback">{{ $errors->first('employee_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#employee_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.leavesTypesId')</label>
                                <select class="form-control" name="leaves_types_id" id="leaves_types_id_dropdown">
                                    @foreach($leavesTypes as $value)
                                        <option value="{{ $value->id }}" {{ (old('leaves_types_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('leaves_types_id'))
                                    <div class="invalid-feedback">{{ $errors->first('leaves_types_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#leaves_types_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.year')</label>
                                <input type="text" class="form-control" id="year_datepicker" name="year" placeholder="@lang('translation.fields.year')" value="{{ old('year', $model?->year ?? '') }}">
                                @if(!empty($errors->first('year')))
                                    <div class="invalid-feedback">{{ $errors->first('year') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#year_datepicker').datepicker({
                                            "format": "yyyy"
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-3 #marginTop">
                                <label class="form-label">@lang('translation.fields.balance')</label>
                                <input type="text" class="form-control" name="balance" placeholder="@lang('translation.fields.balance')" value="{{ old('balance', $model?->balance ?? '') }}">
                                @if(!empty($errors->first('balance')))
                                    <div class="invalid-feedback">{{ $errors->first('balance') }}</div>
                                @endif
                            </div>
						</div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-md">@lang('translation.buttons.submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
