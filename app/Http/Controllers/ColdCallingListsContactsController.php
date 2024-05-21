<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateColdCallingListContact;
use App\Models\ColdCallingListContact;
use App\Models\ColdCallingList;
use App\Models\CompanyContact;

class ColdCallingListsContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ColdCallingListContact::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('cold_calling_lists_id', function($row){
					return $row->coldCallingList->name;
				})
				->addColumn('companies_contacts_id', function($row){
					return $row->companyContact->first_name.' '.$row->companyContact->last_name.' ('.$row->companyContact->company->name.')';
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'cold-calling-lists-contacts.edit',
						'destroy' => 'cold-calling-lists-contacts.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        $coldCallingLists = ColdCallingList::all();
        $currencies = Currency::all();

        return view('cold-calling-lists-contacts.index', compact('data', 'coldCallingLists', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$coldCallingLists = ColdCallingList::all();
		$companyContacts = CompanyContact::all();

		return view('cold-calling-lists-contacts.create', compact('coldCallingLists','companyContacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'cold_calling_lists_id' => 'required',
			'companies_contacts_id' => 'required',
		]);

        $validator = BeforeValidateColdCallingListContact::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('cold-calling-lists-contacts.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('ColdCallingListContact', $request, Auth::user()));
        $model = ColdCallingListContact::create($request->all());
        event(new AfterCreate('ColdCallingListContact', $request, Auth::user(), $model));

        return redirect(route('cold-calling-lists-contacts.index'))->with('success', trans('translation.coldCallingListsContacts.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$coldCallingLists = ColdCallingList::all();
		$companyContacts = CompanyContact::all();

        $model = ColdCallingListContact::find($id);

		return view('cold-calling-lists-contacts.edit', compact('coldCallingLists','companyContacts', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = ColdCallingListContact::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'cold_calling_lists_id' => 'required',
			'companies_contacts_id' => 'required',
		]);

        $validator = BeforeValidateColdCallingListContact::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('cold-calling-lists-contacts.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('ColdCallingListContact', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('ColdCallingListContact', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('cold-calling-lists-contacts.index'))->with('success', trans('translation.coldCallingListsContacts.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = ColdCallingListContact::find($id);
        $model->delete();

        return redirect(route('cold-calling-lists-contacts.index'))->with('success', trans('translation.coldCallingListsContacts.destroy'));
    }

    public function importContacts(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        $records = [];
        foreach ($fileContents as $row => $line) {
            $data = str_getcsv($line);

            if ($row == 0){
                continue;
            }

            $records[] = [
                'index' => $data[0],
                'identifier' => $data[1],
                'companyName' => $data[2],
                'county' => $data[3],
                'caen' => $data[4],
                'avgEmployeesCount' => $data[5],
                'income' => $data[6],
                'url' => $data[7],
                'phone' => $data[8],
                'website' => $data[9],
                'email' => $data[10]
            ];
        }

        foreach ($records as $record){
            $company = Company::where([
                'name' => $record['companyName']
            ])->first();
            if (empty($company)){
                $company = Company::create([
                    'name' => $record['companyName'],
                    'registration_number' => $record['identifier'],
                    'address_line_1' => $record['county'],
                    'website' => $record['website'],
                    'avg_employees_count' => (int)$record['avgEmployeesCount'],
                    'income' => (int)$record['income'],
                    'currency_id' => $request->currency_id
                ]);
            }

            $companyContact = CompanyContact::where([
                'first_name' => 'Administrator',
                'last_name' => '-',
                'position' => 'administrator',
                'company_id' => $company->id
            ])->first();
            if (empty($companyContact)){
                $companyContact = CompanyContact::create([
                    'first_name' => 'Administrator',
                    'last_name' => '-',
                    'position' => 'administrator',
                    'company_id' => $company->id,
                    'email' => $record['email'],
                    'phone' => $record['phone']
                ]);
            }

            ColdCallingListContact::firstOrCreate([
                'cold_calling_lists_id' => $request->cold_calling_lists_id,
                'companies_contacts_id' => $companyContact->id
            ]);
        }

        return redirect()->back()->with('success', trans('translation.coldCallingListsContacts.contactsImportedSuccessfully'));
    }
}
