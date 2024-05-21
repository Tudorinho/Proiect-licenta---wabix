<div class="card overflow-hidden">
    <div class="bg-dark">
        <div class="row">
            <div class="col-7">
                <div class="p-3">
                    <h5 class="text-white">Leaves Overview</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-0" style="height: 123px;overflow-y: scroll;">
        <div class="pt-4">
            <h5>Left days</h5>

            @if(!empty($userLeavesBalances) && !empty($userLeavesBalances->count()))
                @foreach($userLeavesBalances as $userLeavesBalance)
                    <div class="row">
                        <div class="col-6">
                            {{ $userLeavesBalance->leaveType->name }} for  {{ $userLeavesBalance->year }}
                        </div>
                        <div class="col-6">
                            {{ $userLeavesBalance->balance }} hours left
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-12">No leaves balances available.</div>
                </div>
            @endif
        </div>
    </div>

    <div class="card-footer">
        @if(!empty($nextLeave))
            Your next leave starts on: {{ $nextLeave }}
        @else
            There is no leave scheduled for the upcoming period.
        @endif
    </div>
</div>
