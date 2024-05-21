<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Employee;
use App\Models\Event;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Task;
use App\Models\User;
use App\Models\Worklog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function home()
    {
        $leaves = $this->getDashbaordLeaves();
        $events = $this->getDashboardEvents();
        $holidays = $this->getDashboardHolidays();
        $userTask = $this->getDashboardTasks();
        $userWorklogs = $this->getDashboardWorklogs();
        $userMonthlyWorklogs = $this->getDashboardWorklogs(true);
        $monthlyWorklogs = [];
        $totalMonthlyHours = 0;
        foreach ($userMonthlyWorklogs as $userMonthlyWorklog){
            if (empty($monthlyWorklogs[$userMonthlyWorklog->project_id])){
                $monthlyWorklogs[$userMonthlyWorklog->project_id] = [
                    'hours' => $userMonthlyWorklog->hours,
                    'project' => $userMonthlyWorklog->project
                ];
            } else{
                $monthlyWorklogs[$userMonthlyWorklog->project_id] = [
                    'hours' => $monthlyWorklogs[$userMonthlyWorklog->project_id]['hours'] + $userMonthlyWorklog->hours,
                    'project' => $userMonthlyWorklog->project
                ];
            }

            $totalMonthlyHours = $totalMonthlyHours + $userMonthlyWorklog->hours;
        }

        $deals = $this->getDashboardDeals();

        $userId = Auth::user()->id;
        $employee = Employee::where(['user_id' => $userId])->first();
        $userLeavesBalances = [];
        $nextLeave = '';
        if (!empty($employee)){
            $userLeavesBalances = LeaveBalance::where([
                'employee_id' => $employee->id
            ])->get();

            $now = new Carbon();
            $now->setTime(0,0,0);
            $nextLeave = Leave::where('start_date', '>', $now)->where([
                'employee_id' => $employee->id
            ])->first();

            if (!empty($nextLeave)){
                $nextLeave = new Carbon($nextLeave->start_date);
                $nextLeave = $nextLeave->format('Y-m-d');
            }
        }

        return view('home.index', compact(
            'leaves',
            'events',
            'userTask',
            'userWorklogs',
            'holidays',
            'deals',
            'monthlyWorklogs',
            'totalMonthlyHours',
            'userLeavesBalances',
            'nextLeave'
        ));
    }

    public function getDashboardDeals()
    {
        return Deal::orderBy('created_at', 'desc')->limit(20)->get();
    }

    public function getDashboardWorklogs($monthly = false){
        $userId = Auth::user()->id;

        if($monthly){
            $start = new Carbon();
            $start->now();
            $start->startOfMonth();
            $start->setTime(0,0,0);

            $end = new Carbon();
            $end->now();
            $end->lastOfMonth();
            $end->setTime(23,59,59);
        } else{
            $start = new Carbon();
            $start->subDay();
            $start->setTime(0,0,0);

            $end = new Carbon();
            $end->subDay();
            $end->setTime(23,59,59);
        }

        $employee = Employee::where(['user_id' => $userId])->first();
        $worklogs = Worklog::whereBetween('date', [$start, $end])->where([
            'employee_id' => $employee->id
        ])->get();

        return $worklogs;
    }

    public function getDashboardTasks()
    {
        $userId = Auth::user()->id;
        $tasks = Cache::get('dashboard_tasks_'.$userId);
        if (empty($tasks)){
            $start = new Carbon();
            $start->setTime(0,0,0);
            $end = new Carbon();
            $end->setTime(23,59,59);
            $tasks = Task::where([
                'user_id' => $userId,
                'status' => 'pending'
            ])->whereBetween('due_date', [$start, $end])->get();

            $expiresAt = Carbon::now()->addMinutes(60 * 4);
            Cache::set('dashboard_tasks_'.$userId, $tasks, $expiresAt);
        }

        return $tasks;
    }

    public function getDashboardHolidays()
    {
        $events = [];
        $holidays = Holiday::all();

        foreach ($holidays as $holiday){
            $start = new Carbon($holiday->start_date);
            $end = new Carbon($holiday->end_date);
            $end->addDay();

            $events[] = [
                'title' => $holiday->name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'color' => 'black',
                'textColor' => 'yellow'
            ];
        }

        $events = json_encode($events);

        return $events;
    }

    public function getDashboardEvents()
    {
        $data = Event::get();
        $events = [];

        foreach ($data as $event){
            $start = new Carbon($event->start_date);
            $end = new Carbon($event->end_date);
            $end->addDay();

            $events[] = [
                'title' => $event->name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'color' => $event->eventType->color,
                'textColor' => $this->getContrastColor($event->eventType->color)
            ];
        }

        $events = json_encode($events);

        return $events;
    }
    public function getDashbaordLeaves()
    {
        $data = Leave::get();
        $events = [];

        foreach ($data as $leave){
            $start = new Carbon($leave->start_date);
            $end = new Carbon($leave->end_date);
            $end->addDay();

            $color = '#'.bin2hex($leave->employee->first_name.' '.$leave->employee->last_name);

            $events[] = [
                'title' => $leave->employee->first_name.' '.$leave->employee->last_name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'color' => $color,
                'textColor' => $this->getContrastColor($color)
            ];
        }

        $events = json_encode($events);

        return $events;
    }

    public function getContrastColor($hexcolor)
    {
        $r = hexdec(substr($hexcolor, 1, 2));
        $g = hexdec(substr($hexcolor, 3, 2));
        $b = hexdec(substr($hexcolor, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? 'black' : 'white';
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar = '/images/' . $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }

    public function permissions()
    {
        $routesData = Route::getRoutes();
        $roles = ['', 'admin', 'employee'];
        $routes = [];
        $plainRoutes = [];

        foreach ($routesData as $route){
            foreach ($roles as $role){
                $routes[$role][] = [
                    'name' => $route->getName(),
                    'url' => $route->uri,
                    'active' => false
                ];
            }

            $plainRoutes[] = [
                'name' => $route->getName(),
                'url' => $route->uri,
                'active' => false
            ];
        }

        return view('home.permissions', compact('routes', 'roles', 'plainRoutes'));
    }
}
