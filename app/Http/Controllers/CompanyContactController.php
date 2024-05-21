<?php
namespace App\Http\Controllers;

use App\Models\Deal;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateCompanyContact;
use App\Models\CompanyContact;
use App\Models\Company;

class CompanyContactController extends Controller
{
    use DataTableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->getdDtRecords(CompanyContact::class, $request);
            $totalCount = $this->getDtTotalRecords(CompanyContact::class, $request);

            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('first_name', function($row){
					return $row->first_name;
				})
				->addColumn('last_name', function($row){
					return $row->last_name;
				})
				->addColumn('email', function($row){
					return $row->email;
				})
				->addColumn('position', function($row){
					return $row->position;
				})
				->editColumn('company', function($row){
					return $row->company->name;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'companies-contacts.edit',
						'destroy' => 'companies-contacts.destroy',
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('companies-contacts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$companies = Company::all();

		return view('companies-contacts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
			'company_id' => 'required',
		]);

        $validator = BeforeValidateCompanyContact::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('companies-contacts.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('CompanyContact', $request, Auth::user()));
        $model = CompanyContact::create($request->all());
        event(new AfterCreate('CompanyContact', $request, Auth::user(), $model));

        return redirect(route('companies-contacts.index'))->with('success', trans('translation.companyContact.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$companies = Company::all();

        $model = CompanyContact::find($id);

		return view('companies-contacts.edit', compact('companies', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = CompanyContact::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
		]);

        $validator = BeforeValidateCompanyContact::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('error', trans('translation.companyContact.failedToUpdate'));;
        }

        event(new BeforeUpdate('CompanyContact', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('CompanyContact', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect()->back()->with('success', trans('translation.companyContact.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = CompanyContact::find($id);
        $model->delete();

        return redirect(route('companies-contacts.index'))->with('success', trans('translation.companyContact.destroy'));
    }

    public function quickSearch(Request $request)
    {
        $deal = '';
        if ($request->has('deal_id')) {
            $deal = Deal::where([
                'id' => $request->deal_id
            ])->first();
        }

        $data = CompanyContact::query()
            ->select('companies_contacts.*', 'companies.name as companyName')
            ->join('companies', 'companies_contacts.company_id', 'companies.id')
            ->where(function ($q) use ($request, $deal){
                $q->orWhere('companies.name', 'like', '%'.$request->keyword.'%')
                    ->orWhere('companies_contacts.first_name', 'like', '%'.$request->keyword.'%')
                    ->orWhere('companies_contacts.last_name', 'like', '%'.$request->keyword.'%');

                if ($request->has('deal_id')){
                    $q->orWhere('companies_contacts.id', '=', $deal->companies_contacts_id);
                }
            })
            ->orderBy('companies_contacts.first_name', 'asc')
            ->limit(100)
            ->get();

        $results = [];
        foreach ($data as $companyContact){
            $results[] = [
                'text' => $companyContact->first_name.' '.$companyContact->last_name.'('.$companyContact->company->name.')',
                'id' => $companyContact->id
            ];
        }

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => false
            ]
        ]);
    }
}
