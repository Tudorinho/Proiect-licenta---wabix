@foreach($task->emailThread->emailThreadMessages as $emailThreadMessage)
    <div class="message_wrapper {{ $loop->first ? 'message_wrapper_last_message' : '' }}">
        <div>From: {{ $emailThreadMessage->from }}</div>
        <div>To: {{ $emailThreadMessage->from }}</div>
        <div>Date: {{ $emailThreadMessage->date }}</div>
        <div>Subject: {{ $emailThreadMessage->subject }}</div>
        <div>Message:</div>
        <div>{{ $emailThreadMessage->message }}</div>
    </div>
@endforeach
