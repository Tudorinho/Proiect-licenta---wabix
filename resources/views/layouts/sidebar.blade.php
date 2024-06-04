<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.menu.menu')</li>

                <li>
                    <a href="{{ route('home') }}">
                        <i class="bx bxs-dashboard"></i>
                        <span>@lang('translation.menu.dashboard')</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>@lang('translation.menu.system')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'users' ? 'mm-active' : '' }}">
                            <a href="{{ route('users.index') }}" key="t-default">@lang('translation.menu.users')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'currencies' ? 'mm-active' : '' }}">
                            <a href="{{ route('currencies.index') }}" key="t-default">@lang('translation.menu.currencies')</a>
                        </li>
                        {{-- <li class="{{  Request::segment(1) == 'permissions' ? 'mm-active' : '' }}">
                            <a href="{{ route('home.permissions') }}" key="t-default">@lang('translation.menu.permissions')</a>
                        </li> --}}
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span key="t-dashboards">@lang('translation.menu.projects')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'projects' ? 'mm-active' : '' }}">
                            <a href="{{ route('projects.index') }}">@lang('translation.project.projects')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'projects-sources' ? 'mm-active' : '' }}">
                            <a href="{{ route('projects-sources.index') }}">@lang('translation.projectSource.projectsSources')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'projects-statuses' ? 'mm-active' : '' }}">
                            <a href="{{ route('projects-statuses.index') }}">@lang('translation.projectStatus.projectsStatuses')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'projects-priorities' ? 'mm-active' : '' }}">
                            <a href="{{ route('projects-priorities.index') }}">@lang('translation.projectPriority.projectsPriorities')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'projects-contracts-types' ? 'mm-active' : '' }}">
                            <a href="{{ route('projects-contracts-types.index') }}">@lang('translation.projectContractType.projectsContractsTypes')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-dashboards">@lang('translation.menu.humanResources')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  (Request::segment(2) == 'leaves' && Request::segment(2) == 'calendar') ? 'mm-active' : '' }}">
                            <a href="{{ route('leaves.calendar') }}">@lang('translation.leave.calendar')</a>
                        </li>
                        <li class="{{  (Request::segment(2) == 'human-resources' && Request::segment(2) == 'index') ? 'mm-active' : '' }}">
                            <a href="{{ route('human-resources.index') }}">@lang('translation.humanResources.title')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'employees' ? 'mm-active' : '' }}">
                            <a href="{{ route('employees.index') }}">@lang('translation.employee.employees')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'worklogs' &&  Request::segment(2) != 'report' ? 'mm-active' : '' }}">
                            <a href="{{ route('worklogs.index') }}">@lang('translation.worklog.worklogs')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'worklogs' &&  Request::segment(2) == 'report') ? 'mm-active' : '' }}">
                            <a href="{{ route('worklogs.report').'?start_date='.\Carbon\Carbon::now()->subDay()->format('Y-m-d') }}">@lang('translation.worklog.worklogsReport')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'leaves-types' ? 'mm-active' : '' }}">
                            <a href="{{ route('leaves-types.index') }}">@lang('translation.leaveType.leavesTypes')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'holidays' ? 'mm-active' : '' }}">
                            <a href="{{ route('holidays.index') }}">@lang('translation.holiday.holidays')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'leaves' && Request::segment(2) != 'calendar') ? 'mm-active' : '' }}">
                            <a href="{{ route('leaves.index') }}">@lang('translation.leave.leaves')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'leaves-balances' ? 'mm-active' : '' }}">
                            <a href="{{ route('leaves-balances.index') }}">@lang('translation.leaveBalance.leavesBalances')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-task"></i>
                        <span>@lang('translation.menu.tasks')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  (Request::segment(1) == 'tasks' && Request::segment(2) == 'list') ? 'mm-active' : '' }}">
                            <a href="{{ route('tasks.list') }}" key="t-default">@lang('translation.menu.myTasks')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'tasks-lists' ? 'mm-active' : '' }}">
                            <a href="{{ route('tasks-lists.index') }}" key="t-default">@lang('translation.menu.tasksLists')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'tasks-lists-users' ? 'mm-active' : '' }}">
                            <a href="{{ route('tasks-lists-users.index') }}" key="t-default">@lang('translation.menu.tasksListsUsers')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'tasks' && Request::segment(2) != 'list') ? 'mm-active' : '' }}">
                            <a href="{{ route('tasks.index') }}" key="t-default">@lang('translation.menu.tasks')</a>
                        </li>
                        {{-- <li class="{{  Request::segment(1) == 'tasks-statuses-changes' ? 'mm-active' : '' }}">
                            <a href="{{ route('tasks-statuses-changes.index') }}" key="t-default">@lang('translation.menu.tasksStatusesChanges')</a>
                        </li> --}}
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>@lang('translation.menu.crm')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'companies' ? 'mm-active' : '' }}">
                            <a href="{{ route('companies.index') }}" key="t-default">@lang('translation.menu.companies')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'companies-contacts' ? 'mm-active' : '' }}">
                            <a href="{{ route('companies-contacts.index') }}" key="t-default">@lang('translation.menu.companiesContacts')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'deals-statuses' ? 'mm-active' : '' }}">
                            <a href="{{ route('deals-statuses.index') }}" key="t-default">@lang('translation.menu.dealsStatuses')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'deals-sources' ? 'mm-active' : '' }}">
                            <a href="{{ route('deals-sources.index') }}" key="t-default">@lang('translation.menu.dealsSources')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'deals' && Request::segment(2) == 'board') ? 'mm-active' : '' }}">
                            <a href="{{ route('deals.board') }}" key="t-default">@lang('translation.menu.dealsBoard')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'deals' && Request::segment(2) != 'board') ? 'mm-active' : '' }}">
                            <a href="{{ route('deals.index') }}" key="t-default">@lang('translation.menu.deals')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'deals-notes' ? 'mm-active' : '' }}">
                            <a href="{{ route('deals-notes.index') }}" key="t-default">@lang('translation.menu.dealsNotes')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-folder"></i>
                        <span>@lang('translation.menu.documents')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'document-folders' ? 'mm-active' : '' }}">
                            <a href="{{ route('document-folders.index') }}" key="t-default">@lang('translation.menu.documentFolders')</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'languages' ? 'mm-active' : '' }}">
                            <a href="{{ route('languages.index') }}" key="t-default">@lang('translation.languages.languages')</a>
                        </li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>@lang('translation.menu.coldOutreach')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'cold-emailing-credentials' ? 'mm-active' : '' }}">
                            <a href="{{ route('cold-emailing-credentials.index') }}" key="t-default">@lang('translation.menu.coldEmailingCredentials')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'cold-emailing-rules' ? 'mm-active' : '' }}">
                            <a href="{{ route('cold-emailing-rules.index') }}" key="t-default">@lang('translation.menu.coldEmailingRules')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'emails-threads' ? 'mm-active' : '' }}">
                            <a href="{{ route('emails-threads.index') }}" key="t-default">@lang('translation.menu.emailsThreads')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'emails-threads-messages' ? 'mm-active' : '' }}">
                            <a href="{{ route('emails-threads-messages.index') }}" key="t-default">@lang('translation.menu.emailsThreadsMessages')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'cold-calling-lists' ? 'mm-active' : '' }}">
                            <a href="{{ route('cold-calling-lists.index') }}" key="t-default">@lang('translation.menu.coldCallingLists')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'cold-calling-lists-contacts' ? 'mm-active' : '' }}">
                            <a href="{{ route('cold-calling-lists-contacts.index') }}" key="t-default">@lang('translation.menu.coldCallingListsContacts')</a>
                        </li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>@lang('translation.menu.wiki')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(2) == 'wiki' ? 'mm-active' : '' }}">
                            <a href="{{ route('wiki-articles.wiki') }}" key="t-default">@lang('translation.menu.wiki')</a>
                        </li>
                        <li class="{{  Request::segment(1) == 'wiki-categories' ? 'mm-active' : '' }}">
                            <a href="{{ route('wiki-categories.index') }}" key="t-default">@lang('translation.menu.wikiCategories')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'wiki-articles' && Request::segment(2) != 'wiki') ? 'mm-active' : '' }}">
                            <a href="{{ route('wiki-articles.index') }}" key="t-default">@lang('translation.menu.wikiArticles')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>@lang('translation.menu.events')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{  Request::segment(1) == 'events-types' ? 'mm-active' : '' }}">
                            <a href="{{ route('events-types.index') }}" key="t-default">@lang('translation.menu.eventsTypes')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'events' && Request::segment(2) != 'calendar') ? 'mm-active' : '' }}">
                            <a href="{{ route('events.index') }}" key="t-default">@lang('translation.menu.events')</a>
                        </li>
                        <li class="{{  (Request::segment(1) == 'events' && Request::segment(2) == 'calendar') ? 'mm-active' : '' }}">
                            <a href="{{ route('events.calendar') }}" key="t-default">@lang('translation.menu.eventsCalendar')</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
