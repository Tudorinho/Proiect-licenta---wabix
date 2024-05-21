<div class="card overflow-hidden">
    <div class="bg-danger">
        <div class="row">
            <div class="col-7">
                <div class="p-3">
                    <h5 class="text-white">Monthly Worklogs</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body pt-0" style="height: 123px;overflow-y: scroll;">
        <div class="pt-4">
            @if(!empty($monthlyWorklogs))
                @foreach($monthlyWorklogs as $monthlyWorklog)
                    <div class="row mb-3">
                        <div class="col-6">
                            @include('components.columns.label', [
                                'text' => $monthlyWorklog['project']->name,
                                'color' => $monthlyWorklog['project']->color
                            ])
                        </div>
                        <div class="col-6">
                            {{ $monthlyWorklog['hours'] }} hours
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-12">No worklogs found for current month</div>
                </div>
            @endif
        </div>
    </div>

    <div class="card-footer">
        Total logged time this month: {{ $totalMonthlyHours }} hours
    </div>
</div>
