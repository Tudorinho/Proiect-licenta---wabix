<?php
  $dealNotes = $deal->dealNotes;
?>

<button style="float: right; margin-right: 5px;" class="edit btn btn-success btn-sm deal_notes"
        data-bs-toggle="modal"
        data-bs-target="#deal_notes_{{ $deal->id }}">
    <i class="fas fa-pen-nib"></i>
    <span class="badge bg-danger rounded-pill" style="position:absolute; top: -5px;">{{ sizeof($dealNotes) }}</span>
</button>

<div id="deal_notes_{{ $deal->id }}" class="modal modal-xl fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Deal {{ $deal->title }} notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin-bottom: 0px; padding-bottom: 0px;">
                <form action="{{ route('deals-notes.store') }}" method="POST">
                    {{ csrf_field() }}
                    <h5>Add Note</h5>
                    <input type="hidden" name="deals_id" value="{{ $deal->id }}">
                    <textarea name="note" class="form-control" style="resize: none"></textarea>
                    <button type="submit" class="btn btn-primary w-md mt-3">@lang('translation.buttons.addNote')</button>
                </form>
            </div>
            <div class="modal-body" style="max-height: 300px;overflow-y: scroll;">
                    @if(sizeof($dealNotes) == 0)
                        <div>There are no notes added to this deal.</div>
                    @else
                        <table class="table table-striped">
                            @foreach($dealNotes->sortByDesc('created_at') as $dealNote)
                                <tr>
                                    <td>
                                        <div style="color: #ccc; font-weight: bold;">{{ $dealNote->created_at }}</div>
                                        <div>{{ $dealNote->note }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
            </div>
        </div>
    </div>
</div>
