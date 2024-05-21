@extends('layouts.master')

@section('title')
    @lang('translation.humanResources.editHR')
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{ route('companies-contacts.index') }}">@lang('translation.humanResources.title')</a>
        @endslot
        @slot('title')
            @lang('translation.humanResources.editHR')
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
                    <form action="{{ route('human-resources.update', ['id' => $model->id]) }}" method="POST">
                        @method('PUT')
                        {{ csrf_field() }}
						<h5 class="mt-3">@lang('translation.headings.generalInformation')</h5>

						<div class="row">

                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.firstName')</label>
                                <input type="text" class="form-control" name="first_name" placeholder="@lang('translation.fields.firstName')" value="{{ old('first_name', $model?->first_name ?? '') }}">
                                @if(!empty($errors->first('first_name')))
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                @endif
                            </div>

                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.lastName')</label>
                                <input type="text" class="form-control" name="last_name" placeholder="@lang('translation.fields.lastName')" value="{{ old('last_name', $model?->last_name ?? '') }}">
                                @if(!empty($errors->first('last_name')))
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>

                            <div class="col-3 ">
                                <label class="form-label">@lang('translation.fields.date')</label>
                                <input type="text" class="form-control date-picker" name="date_of_birth" placeholder="@lang('translation.fields.date')" value="{{ old('date_of_birth', $model?->date_of_birth ?? '') }}">
                                @if(!empty($errors->first('date_of_birth')))
                                    <div class="invalid-feedback">{{ $errors->first('date_of_birth') }}</div>
                                @endif
                            </div>

                        </div>


                        <h5 class="mt-3">Academic Information</h5>

                        @php
                            $project_index = 0;
                        @endphp

                        <div class="row">
                            <div class="col">
                                <div id="details-container-academic">
                                    @php
                                        $last_index = 0;
                                    @endphp
                                    @foreach($model->academicDetails as $detail_index => $detail)
                                    @php
                                        $last_index = $detail_index + 1;
                                    @endphp
                                        <div class="row detail-row align-items-center mt-3" data-index="{{ $detail_index }}">
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.name')</label>
                                                <input type="text" class="form-control mt-n2" name="details[{{ $detail_index }}][name]" value="{{ $detail->name }}" placeholder="@lang('translation.humanResources.name')">
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.start')</label>
                                                <input type="text" class="form-control date-picker mt-n2" name="details[{{ $detail_index }}][start]" value="{{ $detail->start }}" placeholder="@lang('translation.humanResources.start')">
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.end')</label>
                                                <input type="text" class="form-control date-picker mt-n2" name="details[{{ $detail_index }}][end]" value="{{ $detail->end }}" placeholder="@lang('translation.humanResources.end')">
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.type')</label>
                                                <input type="text" class="form-control mt-n2" name="details[{{ $detail_index }}][type]" value="{{ $detail->type }}" placeholder="@lang('translation.humanResources.type')">
                                            </div>

                                            {{-- Add Project button --}}
                                            <div class="col-2 custom-margin">
                                                <button type="button" class="btn btn-primary add-project add-project-button mt-n2"  data-detail-index="{{ $detail_index }}">@lang('translation.humanResources.addProject')</button>
                                            </div>

                                            <input type="hidden" name="details[{{ $detail_index }}][is_academic]" value="1">

                                            <div class="col-2 custom-margin">
                                                <button type="button" class="btn btn-danger remove-detail mb-2"> - </button>
                                            </div>
                                        </div>

                                        @foreach($detail->projects as $project_index => $project)
                                            <div class="row project-row mt-2 ms-4 detail-{{ $detail_index }}">
                                                <div class="col-2">
                                                    <label class="form-label">Nume Proiect</label>
                                                    <input type="text" class="form-control mt-n2" name="details[{{ $detail_index }}][projects][{{ $project_index }}][name]" value="{{$project->name}}" placeholder="Nume Proiect">
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label">Descriere</label>
                                                    <input type="text" class="form-control mt-n2" name="details[{{ $detail_index }}][projects][{{ $project_index }}][description]" value="{{$project->description}}"  placeholder="Descriere">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">@lang('translation.humanResourcesProjects.technologies')</label>
                                                    <select class="form-control technology_dropdown" name="details[{{ $detail_index }}][projects][{{ $project_index }}][technologies][]" multiple>
                                                        <option value="">@lang('translation.humanResourcesProjects.selectTechnologies')</option>
                                                        @foreach($technologies as $technology)
                                                            @php
                                                                $selected = in_array($technology, json_decode($project->technologies)) ? 'selected' : '';
                                                            @endphp
                                                            <option value="{{ $technology }}" {{ $selected }}> {{ $technology }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-2 align-self-end">
                                                    <button type="button" class="btn btn-danger remove-project">Șterge proiect</button>
                                                </div>
                                            </div>
                                        @endforeach


                                    @endforeach
                                    <!-- Aici vor fi adăugate dinamic blocurile de câmpuri pentru detalii -->
                                </div>
                            </div>
                            <!-- Add Detail Academic Button -->
                            <div class="col-auto text-end">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="add-detail-academic">+</button>
                            </div>
                        </div>


                        {{-- <div class="projects-container" id="projects-container2"></div> --}}

                        <h5 class="mt-3">Professional Information</h5>
                        <div class="row">
                            <div class="col">
                                <div id="details-container-professional">
                                    @foreach($model->professionalDetails as $detail_index => $detail)
                                        <div class="row detail-row align-items-center mt-3" data-index="{{ $detail_index + $last_index}}">
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.name')</label>
                                                <input type="text" class="form-control mt-n2" name="details[{{ $detail_index + $last_index}}][name]" value="{{ $detail->name }}" placeholder="@lang('translation.humanResources.name')">
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.start')</label>
                                                <input type="text" class="form-control date-picker mt-n2" name="details[{{ $detail_index + $last_index}}][start]" value="{{ $detail->start }}" placeholder="@lang('translation.humanResources.start')">
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.end')</label>
                                                <input type="text" class="form-control date-picker mt-n2" name="details[{{ $detail_index + $last_index}}][end]" value="{{ $detail->end }}" placeholder="@lang('translation.humanResources.end')">
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label">@lang('translation.humanResources.type')</label>
                                                <input type="text" class="form-control mt-n2" name="details[{{ $detail_index + $last_index}}][type]" value="{{ $detail->type }}" placeholder="@lang('translation.humanResources.type')">
                                            </div>

                                            {{-- Add Project button --}}
                                            <div class="col-2 custom-margin">
                                                <button type="button" class="btn btn-primary add-project add-project-button mt-n2" data-detail-index="{{ $detail_index + $last_index}}">@lang('translation.humanResources.addProject')</button>
                                            </div>

                                            <input type="hidden" name="details[{{ $detail_index + $last_index}}][is_academic]" value="0">

                                            <div class="col-2 custom-margin">
                                                <button type="button" class="btn btn-danger remove-detail mb-2"> - </button>
                                            </div>
                                        </div>

                                        @foreach($detail->projects as $project_index => $project)
                                            <div class="row project-row mt-2 ms-4 detail-{{ $detail_index + $last_index}}">
                                                <div class="col-2">
                                                    <label class="form-label">Nume Proiect</label>
                                                    <input type="text" class="form-control mt-n2" name="details[{{ $detail_index + $last_index}}][projects][{{ $project_index }}][name]" value="{{$project->name}}" placeholder="Nume Proiect">
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label">Descriere</label>
                                                    <input type="text" class="form-control mt-n2" name="details[{{ $detail_index + $last_index}}][projects][{{ $project_index }}][description]" value="{{$project->description}}"  placeholder="Descriere">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">@lang('translation.humanResourcesProjects.technologies')</label>
                                                    <select class="form-control technology_dropdown" name="details[{{ $detail_index + $last_index}}][projects][{{ $project_index }}][technologies][]" multiple>
                                                        <option value="">@lang('translation.humanResourcesProjects.selectTechnologies')</option>
                                                        @foreach($technologies as $technology)
                                                            @php
                                                                $selected = in_array($technology, json_decode($project->technologies)) ? 'selected' : '';
                                                            @endphp
                                                            <option value="{{ $technology }}" {{ $selected }}> {{ $technology }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-2 align-self-end">
                                                    <button type="button" class="btn btn-danger remove-project">Șterge proiect</button>
                                                </div>
                                            </div>
                                        @endforeach




                                    @endforeach
                                    <!-- Aici vor fi adăugate dinamic blocurile de câmpuri pentru detalii -->
                                </div>
                            </div>
                            <!-- Add Detail Professional Button -->
                            <div class="col-auto text-end">
                                <button type="button" class="btn btn-success waves-effect waves-light" id="add-detail-professional">+</button>
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
    @push('scripts')
        <script>
            $(function() {
                $('#date_datepicker').datepicker({
                    "format": "yyyy-mm-dd"
                });
            });
        </script>
    @endpush
    @push('scripts')
        <script>
            $(function() {
                $('#start_datepicker').datepicker({
                    "format": "yyyy-mm-dd"
                });
            });
        </script>
    @endpush
    @push('scripts')
        <script>
            $(function() {
                $('#end_datepicker').datepicker({
                    "format": "yyyy-mm-dd"
                });
            });
        </script>
    @endpush

    @push('scripts')
    <script>

        $(function() {

            var detailIndex = {{ $detail_index + $last_index + 1}};
            var projectIndex = {{ $project_index + 1 }};

            $('#add-detail-academic').click(function() {
                addDetail(1); // Adaugă detaliu academic
            });

            $('#add-detail-professional').click(function() {
                addDetail(0); // Adaugă detaliu profesional
            });


            // Multiple choices for technologies
            $(function() {
                        $('.technology_dropdown').select2({
                            placeholder: 'Select an option',
                            multiple: true
                        });
                    });

            // Functionality for deleting a detail row
            $('body').on('click', '.remove-detail', function() {
                let detailIndexToRemove = $(this).closest('.detail-row').data('index');
                // Delete the projects associated with the detail
                $(`.detail-${detailIndexToRemove}`).remove();
                $(this).closest('.detail-row').remove();
            });

            // Add the click event for the Add Project button
            // $(`#add-project-${detailIndex}`).click(function() {
            //             console.log($(this));
            //             addProject($(this));
            //         });

            $(".add-project-button").click(function() {
                addProject($(this));
            });

            // Remove project
            $('body').on('click', '.remove-project', function() {
                $(this).closest('.project-row').remove();
            });

            function addProject(button){
                    let detailIndex2 = button.data('detail-index');
                    let project = `
                        <div class="row project-row mt-2 ms-4 detail-${detailIndex2}">
                            <div class="col-2">
                                <label class="form-label">Nume Proiect</label>
                                <input type="text" class="form-control mt-n2" name="details[${detailIndex2}][projects][${projectIndex}][name]" placeholder="Nume Proiect">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Descriere</label>
                                <input type="text" class="form-control mt-n2" name="details[${detailIndex2}][projects][${projectIndex}][description]" placeholder="Descriere">
                            </div>
                            <div class="col-6">
                                <label class="form-label">@lang('translation.humanResourcesProjects.technologies')</label>
                                <select class="form-control technology_dropdown" name="details[${detailIndex2}][projects][${projectIndex}][technologies][]" multiple>
                                    <option value="">@lang('translation.humanResourcesProjects.selectTechnologies')</option>
                                    @foreach($technologies as $technology)
                                        <option value="{{ $technology }}"> {{ $technology}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2 align-self-end">
                                <button type="button" class="btn btn-danger remove-project">Șterge proiect</button>
                            </div>
                        </div>
                    `;

                    button.closest('.detail-row').after(project);

                    $(function() {
                        $('.technology_dropdown').select2({
                            placeholder: 'Select an option',
                            multiple: true
                        });
                    });

                    projectIndex++;

                }



            function addDetail(isAcademic) {
                let detail = `
                    <div class="row detail-row align-items-center mt-3" data-index="${detailIndex}">
                        <div class="col-2">
                            <label class="form-label">@lang('translation.humanResources.name')</label>
                            <input type="text" class="form-control mt-n2" name="details[${detailIndex}][name]" placeholder="@lang('translation.humanResources.name')">
                        </div>
                        <div class="col-2">
                            <label class="form-label">@lang('translation.humanResources.start')</label>
                            <input type="text" class="form-control date-picker mt-n2" name="details[${detailIndex}][start]" placeholder="@lang('translation.humanResources.start')">
                        </div>
                        <div class="col-2">
                            <label class="form-label">@lang('translation.humanResources.end')</label>
                            <input type="text" class="form-control date-picker mt-n2" name="details[${detailIndex}][end]" placeholder="@lang('translation.humanResources.end')">
                        </div>
                        <div class="col-2">
                            <label class="form-label">@lang('translation.humanResources.type')</label>
                            <input type="text" class="form-control mt-n2" name="details[${detailIndex}][type]" placeholder="@lang('translation.humanResources.type')">
                        </div>

                        <input type="hidden" name="details[${detailIndex}][is_academic]" value="${isAcademic}">

                        <div class="col-2 custom-margin">
                            <button type="button" class="btn btn-primary add-project add-project-button mt-n2" data-detail-index="${detailIndex}">@lang('translation.humanResources.addProject')</button>
                        </div>

                        <div class="col-2 custom-margin">
                            <button type="button" class="btn btn-danger remove-detail mb-2"> - </button>
                        </div>
                    </div>
                `;

                if(isAcademic) {
                    $('#details-container-academic').append(detail);
                } else {
                    $('#details-container-professional').append(detail);
                }

                // Add the click event for the Add Project button
                // $(`#add-project-${detailIndex}`).click(function() {
                //         addProject($(this));
                //     });

                $(".add-project-button").click(function() {
                    addProject($(this));
                });

                function addProject(button){
                    let detailIndex2 = button.data('detail-index');
                    let project = `
                        <div class="row project-row mt-2 ms-4 detail-${detailIndex2}">
                            <div class="col-2">
                                <label class="form-label">Nume Proiect</label>
                                <input type="text" class="form-control mt-n2" name="details[${detailIndex2}][projects][${projectIndex}][name]" placeholder="Nume Proiect">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Descriere</label>
                                <input type="text" class="form-control mt-n2" name="details[${detailIndex2}][projects][${projectIndex}][description]" placeholder="Descriere">
                            </div>
                            <div class="col-6">
                                <label class="form-label">@lang('translation.humanResourcesProjects.technologies')</label>
                                <select class="form-control technology_dropdown" name="details[${detailIndex2}][projects][${projectIndex}][technologies][]" multiple>
                                    <option value="">@lang('translation.humanResourcesProjects.selectTechnologies')</option>
                                    @foreach($technologies as $technology)
                                        <option value="{{ $technology }}"> {{ $technology}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2 align-self-end">
                                <button type="button" class="btn btn-danger remove-project">Șterge proiect</button>
                            </div>
                        </div>
                    `;

                    button.closest('.detail-row').after(project);

                    $(function() {
                        $('.technology_dropdown').select2({
                            placeholder: 'Select an option',
                            multiple: true
                        });
                    });

                    projectIndex++;

                }

                // Remove project
                $('body').on('click', '.remove-project', function() {
                    $(this).closest('.project-row').remove();
                });

                $('.date-picker').datepicker({
                    format: 'yyyy-mm-dd'
                });

                detailIndex++; // Incrementează indexul pentru următorul detaliu adăugat
            }

            // Funcționalitate pentru a șterge un rând de detalii
            $('body').on('click', '.remove-detail', function() {
                let detailIndexToRemove = $(this).closest('.detail-row').data('index');
                // Șterge proiectele asociate detaliului care urmează să fie șters
                $(`.detail-${detailIndexToRemove}`).remove();
                $(this).closest('.detail-row').remove();
            });

            // Inițializează date-picker pentru elementele existente
            $('.date-picker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });

    </script>

    <style>
        .custom-margin{
            margin-top: 25px;
        }

        .custom-left{
            margin-left: -150px;
        }
    </style>

    @endpush

@endsection
