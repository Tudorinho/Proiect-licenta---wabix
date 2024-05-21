@if(isset($edit) && !empty($edit))
<a href="{{ route($edit, ['id' => $row->id]) }}" class="edit btn btn-info btn-sm">
    <i class="fas fa-pencil-alt"></i>
</a>
@endif

@if(isset($destroy) && !empty($destroy))
<form action="{{ route($destroy, ['id' => $row->id]) }}" method="POST" style="display: contents;">
    @method('DELETE')
    @csrf
    <button href="{{ route($destroy, ['id' => $row->id]) }}" class="delete btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
    </button>
</form>
@endif

@if(isset($showGeneratePDFButton) && $showGeneratePDFButton == true)
    <a href="{{ route('human-resources.generate-pdf-hr', ['id' => $row->id]) }}" type="button" class="btn btn-success btn-sm waves-effect waves-light">
        <i class="fa fa-download"></i>
    </a>
    <a href="{{ route('human-resources.pdf-blade', ['id' => $row->id]) }}" type="button" class="btn btn-success btn-sm waves-effect waves-light">
        pdf
    </a>
@endif


@if(isset($projectActions) && $projectActions == true)
    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#project_actions_canvas_{{ $row->id }}" id="#project_actions_canvas_{{ $row->id }}_button" aria-controls="offcanvasRight">
        <i class="fas fa-exclamation-circle"></i>
    </button>
    @include('components.columns.projects-actions', ['row' => $row])
@endif

@if(isset($documents) && $documents == true)
    <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#documents_canvas_{{ $row->id }}" id="#documents_canvas_{{ $row->id }}_button" aria-controls="offcanvasRight">
        <i class="fas fa-file"></i>
    </button>
    @include('components.columns.documents', ['row' => $row])
@endif

<script>
    $(document).ready(function(){
        $('#project_action_datepicker_{{ $row->id }}').datepicker({
            "format": "yyyy-mm-dd"
        });
    })
</script>
