<button style="border: 0px;" class="badge badge-pill badge-soft-primary font-size-11"
        data-bs-toggle="modal"
        data-bs-target="#deal_description_{{ $deal->id }}">
    read full description
</button>
<div id="deal_description_{{ $deal->id }}" class="modal modal-xl fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Deal {{ $deal->title }} description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 300px;overflow-y: scroll;">
                {{ $deal->description }}
            </div>
        </div>
    </div>
</div>
