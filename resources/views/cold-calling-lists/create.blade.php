@extends('layouts.master')

@section('title')
    @lang('translation.coldCallingLists.addColdCallingLists')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('cold-calling-lists.index') }}">@lang('translation.coldCallingLists.coldCallingLists')</a>
        @endslot
        @slot('title')
            @lang('translation.coldCallingLists.addColdCallingLists')
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
                    <form action="{{ route('cold-calling-lists.store') }}" method="POST">
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')" value="{{ old('name', $model?->name ?? '') }}">
                                @if(!empty($errors->first('name')))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
						</div>
						<h5 class="mt-3">@lang('translation.headings.taskConfiguration')</h5>

						<div class="row">
                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.tasksListsId')</label>
                                <select class="form-control" name="tasks_lists_id" id="tasks_lists_id_dropdown">
                                    @foreach($tasksLists as $value)
                                        <option value="{{ $value->id }}" {{ (old('tasks_lists_id') == $value->id || (isset($model) && $model->id == $value->id)) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tasks_lists_id'))
                                    <div class="invalid-feedback">{{ $errors->first('tasks_lists_id') }}</div>
                                @endif
                            </div>
                            @push('scripts')
                                <script>
                                    $(function() {
                                        $('#tasks_lists_id_dropdown').select2({
                                            placeholder: 'Select an option'
                                        });
                                    });
                                </script>
                            @endpush
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
