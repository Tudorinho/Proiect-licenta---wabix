<div class="row">
    <div class="col-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="me-3">
                        <p class="text-muted mb-2">Total Tasks</p>
                        <h5 class="mb-0">{{ $taskList->reportData['totals']['tasks'] }}</h5>
                    </div>
                    <div class="avatar-sm ms-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-task"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="me-3">
                        <p class="text-muted mb-2">Total Unique Users</p>
                        <h5 class="mb-0">{{ $taskList->reportData['totals']['unique_users'] }}</h5>
                    </div>
                    <div class="avatar-sm ms-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="me-3">
                        <p class="text-muted mb-2">Avg Tasks Per User</p>
                        <h5 class="mb-0">{{ $taskList->reportData['totals']['avg_tasks_per_user'] }}</h5>
                    </div>
                    <div class="avatar-sm ms-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bxs-user-detail"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="me-3">
                        <p class="text-muted mb-2">Avg Overdue(days)</p>
                        <h5 class="mb-0">{{ $taskList->reportData['totals']['avg_overdue'] }}</h5>
                    </div>
                    <div class="avatar-sm ms-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-timer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="font-weight: normal !important;">
    <div class="col-12">
        <table class="table table-striped">
            <tr style="font-weight: bold !important;">
                <td>Email</td>
                <td>Total Tasks</td>
                <td>Total Tasks Created</td>
                <td>Total Overdue</td>
                <td>Avg Overdue</td>
            </tr>
            @foreach($taskList->reportData['users'] as $user)
                <tr>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['total_tasks'] }}</td>
                    <td>{{ $user['total_tasks_created'] }}</td>
                    <td>{{ $user['total_overdue'] }}</td>
                    <td>{{ $user['avg_overdue'] }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>


