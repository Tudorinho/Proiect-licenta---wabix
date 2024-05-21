<div class="offcanvas offcanvas-end" tabindex="-1" id="documents_canvas_{{ $row->id }}">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">{{ $row->name }} Documents</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-header pt-0 pb-0">
        <div class="col-12">
            <button style="width: 100%" type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#add_document_{{ $row->id }}">Add Document</button>
        </div>
    </div>

    <div id="add_document_{{ $row->id }}" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Document for {{ $row->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.add-document', ['id'=> $row->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="entity_id" value="{{ $row->id }}">
                        <input type="hidden" name="entity_type" value="project">
                        <input type="hidden" name="type" value="link">
                        <input type="hidden" name="view" value="{{ isset($_GET['view']) ? $_GET['view'] : '' }}">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">@lang('translation.fields.name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('translation.fields.name')">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">@lang('translation.fields.data')</label>
                                <input type="text" class="form-control" name="data" placeholder="@lang('translation.fields.data')">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-md">@lang('translation.buttons.submit')</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="offcanvas-body">
        <table class="table table-striped">
            <tr>
                <td>Link</td>
                <td>Name</td>
                <td>Date</td>
            </tr>
            @foreach($row->getDocuments() as $document)
                <tr>
                    <td>
                        <a href="{{ $document->data }}" target="_blank">
                            <i class="fas fa-link"></i>
                        </a>
                    </td>
                    <td>{{ $document->name }}</td>
                    <td>{{ $document->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</div>

<style>
    .modal-backdrop{
        display: none !important;
    }
</style>
