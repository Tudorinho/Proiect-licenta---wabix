<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateEvent;
use App\Models\Event;
use App\Models\EventType;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Event::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('events_types_id', function($row){
					return $row->eventType->name;
				})
				->addColumn('start_date', function($row){
					return $row->start_date;
				})
				->addColumn('end_date', function($row){
					return $row->end_date;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'events.edit',
						'destroy' => 'events.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('events.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$eventsTypes = EventType::all();

		return view('events.create', compact('eventsTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
			'events_types_id' => 'required',
		]);

        $validator = BeforeValidateEvent::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('events.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Event', $request, Auth::user()));
        $model = Event::create($request->all());
        event(new AfterCreate('Event', $request, Auth::user(), $model));

        return redirect(route('events.index'))->with('success', trans('translation.event.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$eventsTypes = EventType::all();

        $model = Event::find($id);

		return view('events.edit', compact('eventsTypes', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Event::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
			'events_types_id' => 'required',
		]);

        $validator = BeforeValidateEvent::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('events.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Event', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Event', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('events.index'))->with('success', trans('translation.event.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Event::find($id);
        $model->delete();

        return redirect(route('events.index'))->with('success', trans('translation.event.destroy'));
    }

    public function calendar(Request $request)
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

        return view('events.calendar', compact('events'));
    }

    public function getContrastColor($hexcolor)
    {
        $r = hexdec(substr($hexcolor, 1, 2));
        $g = hexdec(substr($hexcolor, 3, 2));
        $b = hexdec(substr($hexcolor, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? 'black' : 'white';
    }
}
