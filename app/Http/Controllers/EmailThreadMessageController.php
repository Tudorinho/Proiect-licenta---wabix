<?php
namespace App\Http\Controllers;

use App\Traits\DataTableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateEmailThreadMessage;
use App\Models\EmailThreadMessage;
use App\Models\EmailThread;

class EmailThreadMessageController extends Controller
{
    use DataTableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->getdDtRecords(EmailThreadMessage::class, $request);
            $totalCount = $this->getDtTotalRecords(EmailThreadMessage::class, $request);

            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('subject', function($row){
					return $row->subject;
				})
				->addColumn('date', function($row){
					return $row->date;
				})
				->addColumn('from', function($row){
					return $row->from;
				})
				->addColumn('to', function($row){
					return $row->to;
				})
				->addColumn('emails_threads_id', function($row){
					return $row->emailThread->identifier;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'emails-threads-messages.edit',
						'destroy' => 'emails-threads-messages.destroy',
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('emails-threads-messages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$emailsThreads = EmailThread::all();

		return view('emails-threads-messages.create', compact('emailsThreads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'emails_threads_id' => 'required',
		]);

        $validator = BeforeValidateEmailThreadMessage::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('emails-threads-messages.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('EmailThreadMessage', $request, Auth::user()));
        $model = EmailThreadMessage::create($request->all());
        event(new AfterCreate('EmailThreadMessage', $request, Auth::user(), $model));

        return redirect(route('emails-threads-messages.index'))->with('success', trans('translation.emailThreadMessage.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$emailsThreads = EmailThread::all();

        $model = EmailThreadMessage::find($id);

		return view('emails-threads-messages.edit', compact('emailsThreads', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = EmailThreadMessage::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'emails_threads_id' => 'required',
		]);

        $validator = BeforeValidateEmailThreadMessage::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('emails-threads-messages.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('EmailThreadMessage', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('EmailThreadMessage', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('emails-threads-messages.index'))->with('success', trans('translation.emailThreadMessage.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = EmailThreadMessage::find($id);
        $model->delete();

        return redirect(route('emails-threads-messages.index'))->with('success', trans('translation.emailThreadMessage.destroy'));
    }
}
