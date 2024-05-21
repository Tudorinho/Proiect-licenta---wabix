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
use App\Validators\BeforeValidateEmailThread;
use App\Models\EmailThread;
use App\Models\CompanyContact;

class EmailThreadController extends Controller
{
    use DataTableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->getdDtRecords(EmailThread::class, $request);
            $totalCount = $this->getDtTotalRecords(EmailThread::class, $request);

            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('identifier', function($row){
					return $row->identifier;
				})
				->addColumn('companies_contacts_id', function($row){
					return $row->companyContact->first_name.' '.$row->companyContact->last_name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'emails-threads.edit',
						'destroy' => 'emails-threads.destroy',
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('emails-threads.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$companiesContacts = CompanyContact::all();

		return view('emails-threads.create', compact('companiesContacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'identifier' => 'required',
			'companies_contacts_id' => 'required',
		]);

        $validator = BeforeValidateEmailThread::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('emails-threads.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('EmailThread', $request, Auth::user()));
        $model = EmailThread::create($request->all());
        event(new AfterCreate('EmailThread', $request, Auth::user(), $model));

        return redirect(route('emails-threads.index'))->with('success', trans('translation.emailThread.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$companiesContacts = CompanyContact::all();

        $model = EmailThread::find($id);

		return view('emails-threads.edit', compact('companiesContacts', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = EmailThread::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'identifier' => 'required',
			'companies_contacts_id' => 'required',
		]);

        $validator = BeforeValidateEmailThread::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('emails-threads.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('EmailThread', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('EmailThread', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('emails-threads.index'))->with('success', trans('translation.emailThread.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = EmailThread::find($id);
        $model->delete();

        return redirect(route('emails-threads.index'))->with('success', trans('translation.emailThread.destroy'));
    }
}
