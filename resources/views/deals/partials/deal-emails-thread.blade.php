<button style="float: right; margin-right: 5px;" class="edit btn btn-warning btn-sm deal_messages"
        data-bs-toggle="modal"
        data-bs-target="#deal_messages_{{ $deal->id }}">
    <i class="fas fa-envelope"></i>
</button>
<div id="deal_messages_{{ $deal->id }}" class="modal modal-xl fade" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Deal {{ $deal->title }} messages</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 300px;overflow-y: scroll;">
                @if(empty($deal->emailThread) || empty($deal->emailThread->emailThreadMessages))
                    <div class="message_wrapper">There are no emails associated with this deal.</div>
                @else
                    @foreach($deal->emailThread->emailThreadMessages as $emailThreadMessage)
                        <div class="message_wrapper {{ $loop->first ? 'message_wrapper_last_message' : '' }}">
                            <div>From: {{ $emailThreadMessage->from }}</div>
                            <div>To: {{ $emailThreadMessage->from }}</div>
                            <div>Date: {{ $emailThreadMessage->date }}</div>
                            <div>Subject: {{ $emailThreadMessage->subject }}</div>
                            <div>Message:</div>
                            <div>{{ $emailThreadMessage->message }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
