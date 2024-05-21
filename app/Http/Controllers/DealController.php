<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Events\AfterCreate;
use App\Events\AfterUpdate;
use App\Events\BeforeCreate;
use App\Events\BeforeUpdate;
use App\Validators\BeforeValidateDeal;
use App\Models\Deal;
use App\Models\User;
use App\Models\CompanyContact;
use App\Models\DealStatus;
use App\Models\DealSource;
use App\Models\Currency;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Deal::get();

        if ($request->ajax()) {
            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('title', function($row){
					return $row->title;
				})
				->addColumn('user_id', function($row){
					return $row->user->email;
				})
				->addColumn('companies_contacts_id', function($row){
					return $row->companyContact->first_name.' '.$row->companyContact->last_name.'('.$row->companyContact->company->name.')';
				})
				->addColumn('deals_statuses_id', function($row){
					return $row->dealStatus->name;
				})
				->addColumn('deals_sources_id', function($row){
					return $row->dealSource->name;
				})
				->addColumn('currency_id', function($row){
					return $row->currency->name;
				})
				->addColumn('type', function($row){
					return $row->type;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'deals.edit',
						'destroy' => 'deals.destroy',
					]);
				})
				->rawColumns(['action'])
                ->make(true);
        }

        return view('deals.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$users = User::all();
		$companiesContacts = CompanyContact::all();
		$dealsStatuses = DealStatus::all();
		$dealsSources = DealSource::all();
		$currencies = Currency::all();
		$types = ['new_deal','upsell'];

		return view('deals.create', compact('users','companiesContacts','dealsStatuses','dealsSources','currencies','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'deals_statuses_id' => 'required',
			'currency_id' => 'required',
			'title' => 'required',
			'deal_size' => 'numeric',
		]);

        $validator = BeforeValidateDeal::run($validator, $request, Auth::user());

        if ($validator->fails()) {
            return redirect(route('deals.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('Deal', $request, Auth::user()));
        $model = Deal::create($request->all());
        event(new AfterCreate('Deal', $request, Auth::user(), $model));

        return redirect(route('deals.index'))->with('success', trans('translation.deal.store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$users = User::all();
		$companiesContacts = CompanyContact::all();
		$dealsStatuses = DealStatus::all();
		$dealsSources = DealSource::all();
		$currencies = Currency::all();
		$types = ['new_deal','upsell'];

        $model = Deal::find($id);

		return view('deals.edit', compact('users','companiesContacts','dealsStatuses','dealsSources','currencies','types', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = Deal::find($id);
        $originalModelAttributes = $model->getAttributes();

		$validator = Validator::make($request->all(), [
			'deals_statuses_id' => 'required',
			'currency_id' => 'required',
			'title' => 'required',
			'deal_size' => 'numeric',
		]);

        $validator = BeforeValidateDeal::run($validator, $request, Auth::user(), $model);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('danger', trans('translation.deal.failedToUpdate'));
        }

        event(new BeforeUpdate('Deal', $request, Auth::user(), $model));
        $model->update($request->all());
        event(new AfterUpdate('Deal', $request, Auth::user(), $model, $originalModelAttributes));

        return redirect()->back()->with('success', trans('translation.deal.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = Deal::find($id);
        $model->dealNotes()->delete();
        $model->delete();

        return redirect(route('deals.index'))->with('success', trans('translation.deal.destroy'));
    }

    public function board(Request $request){
        $dealsStatuses = DealStatus::orderBy('order', 'asc')->get();
        $dealsSources = DealSource::all();
        $users = User::all();
        $companiesContacts = CompanyContact::limit(100)->get();
        $currencies = Currency::all();
        $types = ['new_deal','upsell'];

        $dealsModels = Deal::all();
        $deals = [];
        foreach ($dealsModels as $dealsModel){
            $deals[$dealsModel->deals_statuses_id][] = $dealsModel;
        }
        foreach ($dealsStatuses as $dealsStatus){
            if (empty($deals[$dealsStatus->id])){
                $deals[$dealsStatus->id] = [];
            }
        }

        return view('deals.board', compact(
            'dealsStatuses',
            'dealsSources',
            'deals',
            'users',
            'companiesContacts',
            'currencies',
            'types'
        ));
    }
}
