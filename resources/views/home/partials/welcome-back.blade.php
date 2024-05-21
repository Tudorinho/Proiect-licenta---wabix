<div class="card overflow-hidden">
    <div class="bg-primary-subtle">
        <div class="row">
            <div class="col-7">
                <div class="text-primary p-3">
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p>{{ \Illuminate\Support\Facades\Auth::user()->email }}</p>
                </div>
            </div>
            <div class="col-5 align-self-end">
                <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-sm-4">
                <div class="avatar-md profile-user-wid mb-4">
                    <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('build/images/users/avatar-1.jpg') }}" alt="" class="img-thumbnail rounded-circle">
                </div>
            </div>

            <div class="col-sm-8">
                <div class="pt-4">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="font-size-15">{{ sizeof($userTask) }}</h5>
                            <p class="text-muted mb-0">Today Tasks</p>
                        </div>
                        <div class="col-6">
                            <h5 class="font-size-15">{{ $userWorklogs->sum('hours') }} hours</h5>
                            <p class="text-muted mb-0">Yesterday Worklogs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
