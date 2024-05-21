<?php
namespace App\Http\Controllers;

use App\Models\CompanyContact;
use App\Models\Currency;
use App\Models\Deal;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateCompany;
use App\Models\Company;


class CompanyController extends Controller
{
    use DataTableTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $data = $this->getdDtRecords(Company::class, $request);
            $totalCount = $this->getDtTotalRecords(Company::class, $request);

            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('name', function($row){
					return $row->name;
				})
				->addColumn('registration_number', function($row){
					return $row->registration_number;
				})
				->addColumn('type', function($row){
					return $row->type;
				})
				->addColumn('created_at', function($row){
					return $row->created_at;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'companies.edit',
						'destroy' => 'companies.destroy',
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$types = ['lead','prospect','customer','supplier'];
        $currencies = Currency::all();

		return view('companies.create', compact('types', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'avg_employees_count' => 'numeric',
			'income' => 'numeric',
			'profit' => 'numeric'
		]);

        $validator = BeforeValidateCompany::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('companies.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Company', $request, Auth::user()));
        $model = Company::create($request->all());
        event(new AfterCreate('Company', $request, Auth::user(), $model));

        return redirect(route('companies.index'))->with('success', trans('translation.company.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$types = ['lead','prospect','customer','supplier'];
        $currencies = Currency::all();

        $model = Company::find($id);

		return view('companies.edit', compact('types', 'currencies', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Company::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'avg_employees_count' => 'numeric',
            'income' => 'numeric',
            'profit' => 'numeric'
		]);

        $validator = BeforeValidateCompany::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect(route('companies.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeUpdate('Company', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Company', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect(route('companies.index'))->with('success', trans('translation.company.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Company::find($id);
        $model->delete();

        return redirect(route('companies.index'))->with('success', trans('translation.company.destroy'));
    }

    public function quickSearch(Request $request)
    {
        $data = Company::query()
            ->select('*')
            ->where(function ($q) use ($request){
                $q->orWhere('name', 'like', '%'.$request->keyword.'%');
            })
            ->orderBy('name', 'asc')
            ->limit(100)
            ->get();

        $results = [];
        foreach ($data as $company){
            $results[] = [
                'text' => $company->name,
                'id' => $company->id
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
