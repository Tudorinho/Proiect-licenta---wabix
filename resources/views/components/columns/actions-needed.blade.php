<div class="d-flex flex-wrap gap-1">
    @if(!empty($nextDueDate))
        <button type="button" class="btn btn-warning position-relative btn-sm">
            {{ (new DateTime($nextDueDate->due_date))->format('Y-m-d') }}
            <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success">
            Next Due Date
        </span>
        </button>
    @endif

    <button type="button" class="btn btn-primary position-relative">
        In Progress
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
            {{ $inProgress }}
        </span>
    </button>
    <button type="button" class="btn btn-info position-relative">
        Not Started
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
            {{ $notStarted }}
        </span>
    </button>
</div>
