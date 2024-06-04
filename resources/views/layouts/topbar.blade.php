<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">W</span>
                    <span class="logo-lg" style="font-size: 28px; color: #ffffff;">Wabix</span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm" style="font-size: 28px; color: #ffffff;">W</span>
                    <span class="logo-lg" style="font-size: 28px; color: #ffffff;">Wabix</span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

           <!-- App Search-->
           {{-- <form class="app-search d-none d-lg-block">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="@lang('translation.header.search')">
                <span class="bx bx-search-alt"></span>
            </div>
        </form> --}}
    </div>

    <div class="d-flex">
        <div class="dropdown d-inline-block d-lg-none ms-2">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-magnify"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-search-dropdown">

                <form class="p-3">
                    <div class="form-group m-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="@lang('translation.Search')" aria-label="Search input">

                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="dropdown d-none d-lg-inline-block ms-1">
            <button type="button" class="btn header-item noti-icon waves-effect"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-customize"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <div class="px-lg-2">
                    <div class="row g-0">
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('tasks.list') }}">
                                <i class="fas fa-tasks" style="font-size: 20px"></i>
                                <span>My Tasks</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('leaves.calendar') }}">
                                <i class="fas fa-calendar" style="font-size: 20px"></i>
                                <span>Calendar</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('wiki-articles.wiki') }}">
                                <i class="fas fa-file" style="font-size: 20px"></i>
                                <span>Wiki</span>
                            </a>
                        </div>

                    </div>

                    <div class="row g-0">
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('worklogs.index') }}">
                                <i class="fas fa-clock" style="font-size: 20px"></i>
                                <span>Worklogs</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('events.calendar') }}">
                                <i class="fas fa-calendar-alt" style="font-size: 20px"></i>
                                <span>Events</span>
                            </a>
                        </div>
                        {{-- <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('deals.board') }}">
                                <i class="fas fa-cash-register" style="font-size: 20px"></i>
                                <span>Deals</span>
                            </a>
                        </div> --}}
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('document-folders.index') }}">
                                <i class="fas fa-folder" style="font-size: 20px"></i>
                                <span>Documents</span>
                            </a>
                        </div>
                    </div>

                    {{-- <div class="row g-0">
                        <div class="col">
                            <a class="dropdown-icon-item" href="{{ route('document-folders.index') }}">
                                <i class="fas fa-folder" style="font-size: 20px"></i>
                                <span>Documents</span>
                            </a>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <?php
                $userId = \Illuminate\Support\Facades\Auth::user()->id;
                $tasks = \Illuminate\Support\Facades\Cache::get('header_tasks_'.$userId);
                if (empty($tasks)){
                    $start = new \Carbon\Carbon();
                    $start->setTime(0,0,0);
                    $end = new \Carbon\Carbon();
                    $end->setTime(23,59,59);
                    $tasks = \App\Models\Task::where([
                        'user_id' => $userId,
                        'status' => 'pending'
                    ])->whereBetween('due_date', [$start, $end])->get();

                    $expiresAt = \Carbon\Carbon::now()->addMinutes(60 * 4);
                    \Illuminate\Support\Facades\Cache::set('header_tasks_'.$userId, $tasks, $expiresAt);
                }
            ?>

            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-bell bx-tada"></i>
                <span class="badge bg-danger rounded-pill">{{ sizeof($tasks) }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-0" key="t-notifications">@lang('translation.content.todayTasks') </h6>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('tasks.list') }}" class="small" key="t-view-all">@lang('translation.content.viewAll')</a>
                        </div>
                    </div>
                </div>
                <div data-simplebar style="max-height: 230px;">
                    @if(empty($tasks))
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">@lang('translation.content.noTasks')</h6>
                                </div>
                            </div>
                        </a>
                    @endif
                    @foreach($tasks as $task)
                        <a href="" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $task->title }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-occidental">{{ substr($task->description, 0, 100) }}</p>
                                        <p class="mb-0">
                                            <span class="badge rounded-pill badge-soft-primary font-size-11">{{ $task->taskList->name }}</span>
                                            @if($task->priority == 'low')
                                                <span class="badge rounded-pill badge-soft-success font-size-11">Low</span>
                                            @elseif($task->priority == 'medium')
                                                <span class="badge rounded-pill badge-soft-warning font-size-11">Medium</span>
                                            @else
                                                <span class="badge rounded-pill badge-soft-danger font-size-11">High</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="p-2 border-top d-grid">
                    <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('tasks.list') }}">
                        <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">@lang('translation.content.viewAll')</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
{{--                <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('build/images/users/avatar-1.jpg') }}"--}}
{{--                    alt="Header Avatar">--}}
                <i class="bx bx-user" style="font-size: 22px;"></i>
{{--                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst(Auth::user()->name)}}</span>--}}
{{--                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>--}}
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('users.profile') }}">
                    <i class="bx bx-user font-size-16 align-middle me-1"></i>
                    <span key="t-profile">@lang('translation.content.profile')</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                    <span key="t-logout">@lang('translation.content.logout')</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                <i class="bx bx-cog bx-spin"></i>
            </button>
        </div>
    </div>
</div>
</header>
<!--  Change-Password example -->
<div class="modal fade change-password" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="change-password">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                    <div class="mb-3">
                        <label for="current_password">Current Password <span class="text-danger">*</span></label>
                        <input id="current-password" type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            name="current_password" autocomplete="current_password"
                            placeholder="Enter Current Password" value="{{ old('current_password') }}">
                        <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password"></div>
                    </div>

                    <div class="mb-3">
                        <label for="newpassword">New Password <span class="text-danger">*</span></label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            autocomplete="new_password" placeholder="Enter New Password">
                        <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
                    </div>

                    <div class="mb-3">
                        <label for="userpassword">Confirm Password <span class="text-danger">*</span></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            autocomplete="new_password" placeholder="Enter New Confirm password">
                        <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm"></div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdatePassword" data-id="{{ Auth::user()->id }}"
                            type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
