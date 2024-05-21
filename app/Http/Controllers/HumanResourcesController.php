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
use App\Models\HumanResource;
use App\Models\HumanResourceDetails;
use App\Models\HumanResourceProject;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as Snappy;
use Illuminate\Http\Response;




class HumanResourcesController extends Controller
{
    use DataTableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showGeneratePDFButton = true;

        if ($request->ajax()) {
            $data = $this->getdDtRecords(HumanResource::class, $request);
            $totalCount = $this->getDtTotalRecords(HumanResource::class, $request);

            return Datatables::of($data)
				->addIndexColumn()
				->addColumn('first_name', function($row){
					return $row->first_name;
				})
				->addColumn('last_name', function($row){
					return $row->last_name;
				})
				->addColumn('date_of_birth', function($row){
					return $row->date_of_birth;
				})
				->addColumn('action', function($row){
					return view('components.columns.actions', [
						'row' => $row,
						'edit' => 'human-resources.edit',
						'destroy' => 'human-resources.destroy',
                        'showGeneratePDFButton' => true,
					]);
				})
				->rawColumns(['action'])
                ->setTotalRecords(sizeof($data))
                ->setFilteredRecords($totalCount)
                ->skipPaging()
                ->make(true);
        }

        return view('human-resources.index', compact('showGeneratePDFButton'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technologies = ["JS", "PHP", "CSS"];
        return view('human-resources.create', compact('technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->details);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'details.*.name' => 'required|string|max:255',
            'details.*.start' => 'required|date',
            'details.*.end' => 'nullable|date',
            'details.*.type' => 'required|string|max:255',
            'details.*.is_academic' => 'required|boolean',
            'details.*.projects.*.name' => 'required|string|max:255',
            'details.*.projects.*.description' => 'required|string|max:255',
            'details.*.projects.*.technologies' => 'nullable|array',
            'details.*.projects.*.technologies.*' => 'string', // Dacă vrei să validezi fiecare tehnologie în parte
        ]);

        if ($validator->fails()) {
            return redirect(route('human-resources.create'))->withInput()->withErrors($validator->errors());
        }

        event(new BeforeCreate('HumanResource', $request, Auth::user()));
        $model = HumanResource::create($request->all());
        event(new AfterCreate('HumanResource', $request, Auth::user(), $model));

         // Crearea detaliilor HumanResourceDetails și a proiectelor asociate
        if ($request->has('details')) {
            foreach ($request->input('details') as $detailData) {
                $detailData['human_resource_id'] = $model->id;
                $detail = HumanResourceDetails::create($detailData);

                // Verifică dacă există proiecte pentru acest detaliu și creează-le
                if (isset($detailData['projects'])) {
                    // dd($detailData);
                    foreach ($detailData['projects'] as $projectData) {
                        $projectData['technologies'] = json_encode($projectData['technologies']);
                        $projectData['human_resource_detail_id'] = $detail->id;
                        $project = HumanResourceProject::create($projectData);
                    }
                }
            }
        }


        return redirect(route('human-resources.index'))->with('success', 'Human resource created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HumanResource $humanResource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $technologies = ["JS", "PHP", "CSS"];
        $model = HumanResource::find($id);

        // event(new BeforeCreate('HumanResource', $request, Auth::user()));
        // $model = HumanResource::create($request->all());
        // event(new AfterCreate('HumanResource', $request, Auth::user(), $model));

        // Converteste tehnologiile proiectului in array
        $projectTechnologies = explode(',', $model->technologies);

        return view('human-resources.edit', compact('model', 'technologies', 'projectTechnologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'details.*.name' => 'required|string|max:255',
            'details.*.start' => 'required|date',
            'details.*.end' => 'nullable|date',
            'details.*.type' => 'required|string|max:255',
            'details.*.is_academic' => 'required|boolean',
            'details.*.projects.*.name' => 'required|string|max:255',
            'details.*.projects.*.description' => 'required|string|max:255',
            'details.*.projects.*.technologies' => 'nullable|array',
            'details.*.projects.*.technologies.*' => 'string',
        ]);

        $model = HumanResource::find($id);

        if ($validator->fails()) {
            return redirect(route('human-resources.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }


        // dd($request->input('details'));

        //  Crearea detaliilor HumanResourceDetails și a proiectelor asociate
        if ($request->has('details')) {
            $model->details()->delete();
            foreach ($request->input('details') as $detailData) {
                $detailData['human_resource_id'] = $model->id;
                $detail = HumanResourceDetails::create($detailData);

                // Verifică dacă există proiecte pentru acest detaliu și creează-le
                if (isset($detailData['projects'])) {
                    // dd($detailData);
                    $detail->projects()->delete();
                    foreach ($detailData['projects'] as $projectData) {
                        $projectData['technologies'] = json_encode($projectData['technologies']);
                        $projectData['human_resource_detail_id'] = $detail->id;
                        $project = HumanResourceProject::create($projectData);
                    }
                }
            }
        }

        return redirect(route('human-resources.index'))->with('success', 'Human resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $humanResource = HumanResource::find($id);
        $humanResource->delete();

        return redirect(route('human-resources.index'))->with('success', 'Human resource deleted successfully.');
    }

    public function generatePDFHR($id)
    {
        $humanResource = HumanResource::with('details.projects')->find($id);
        $data = [
            'humanResource' => $humanResource,
        ];

        $pdf = PDF::loadView('human-resources.pdfhr', $data);

        return $pdf->download('human_resources_cv.pdf');
    }

    public function PDFblade($id)
    {
        $humanResource = HumanResource::with('details.projects')->find($id);
        $data = [
            'humanResource' => $humanResource,
        ];

        // $pdf = PDF::loadView('human-resources.pdfhr', $data);

        // return $pdf->download('human_resources_cv.pdf');

        return view('human-resources.pdfhr', compact('data', 'humanResource'));
    }

}
