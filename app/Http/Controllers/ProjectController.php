<?php
namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Document;
use App\Models\Project;
use App\Models\ProjectAction;
use App\Models\ProjectContractType;
use App\Models\ProjectPriority;
use App\Models\ProjectSource;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $data = Project::with('projectSource', 'projectPriority', 'projectStatus', 'projectContractType')->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return view('components.columns.actions', [
                        'row' => $row,
                        'edit' => 'projects.edit',
                        'destroy' => 'projects.destroy',
                        'projectActions' => true,
                        'documents' => true
                    ]);
                })
                ->addColumn('project_priority_id', function($row){
                    return view('components.columns.label', [
                        'text' => $row->projectPriority->name,
                        'color' => $row->projectPriority->color
                    ]);
                })
                ->addColumn('name', function($row){
                    return view('components.columns.label', [
                        'text' => $row->name,
                        'color' => $row->color
                    ]);
                })
                ->addColumn('project_status_id', function($row){
                    return view('components.columns.label', [
                        'text' => $row->projectStatus->name,
                        'color' => $row->projectStatus->color
                    ]);
                })
                ->addColumn('project_contract_type_id', function($row){
                    return view('components.columns.label', [
                        'text' => $row->projectContractType->name,
                        'color' => $row->projectContractType->color
                    ]);
                })
                ->addColumn('project_source_id', function($row){
                   return $row->projectSource->name;
                })
                ->addColumn('actions_needed', function($row){
                    return view('components.columns.actions-needed', [
                        'notStarted' => $row->projectActions()->where([
                            'status' => 'not_started'
                        ])->count(),
                        'inProgress' => $row->projectActions()->where([
                            'status' => 'in_progress'
                        ])->count(),
                        'nextDueDate' => $row->projectActions()->whereIn('status', ['not_started', 'in_progress'])->orderBy('due_date', 'asc')->first()
                    ]);
                })
                ->rawColumns(['actions_needed', 'action'])
                ->make(true);
        }

        $actions = $request->actions;
        $documents = $request->documents;

        $view = $request->view;
        if ($view == 'kanban'){
            $projects = [];
            $projectStatuses = [];
            foreach ($data as $project){
                $projectStatuses[$project->projectStatus->name] = $project->projectStatus->color;
                $projects[$project->projectStatus->name][] = $project;
            }

            $actions = $request->actions;
            $documents = $request->documents;

            return view('projects.kanban', compact('projects', 'actions', 'documents', 'projectStatuses'));
        } else{
            return view('projects.index', compact('data', 'actions', 'documents'));
        }
    }

    public function create()
    {
        $projectContractTypes = ProjectContractType::all();
        $projectPriorities = ProjectPriority::all();
        $projectStatuses = ProjectStatus::all();
        $projectSources = ProjectSource::all();
        $currencies = Currency::all();

        return view('projects.create', compact(['projectStatuses', 'projectPriorities', 'projectContractTypes', 'projectSources', 'currencies']));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'project_status_id' => 'required',
            'project_priority_id' => 'required',
            'project_contract_type_id' => 'required',
            'project_source_id' => 'required',
            "currency_id" => 'required',
            "flat_estimated_value" => 'numeric|nullable',
            "flat_negotiated_value" => 'numeric|nullable',
            "flat_accepted_value" => 'numeric|nullable'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects.create'))->withInput()->withErrors($validator->errors());
        }

        $data = [
            'name' => $request->name,
            'color' => $request->color ?? '#000000',
            'project_status_id' => $request->project_status_id,
            'project_priority_id' => $request->project_priority_id,
            'project_contract_type_id' => $request->project_contract_type_id,
            'project_source_id' => $request->project_source_id,
            'currency_id' => $request->currency_id,
            'flat_estimated_value' => $request->flat_estimated_value ?? 0,
            'flat_negotiated_value' => $request->flat_negotiated_value ?? 0,
            'flat_accepted_value' => $request->flat_accepted_value ?? 0
        ];

        Project::create($data);

        return redirect(route('projects.index'))->with('success', trans('translation.project.store'));
    }

    public function edit($id)
    {
        $projectContractTypes = ProjectContractType::all();
        $projectPriorities = ProjectPriority::all();
        $projectStatuses = ProjectStatus::all();
        $projectSources = ProjectSource::all();
        $currencies = Currency::all();

        $model = Project::find($id);

        return view('projects.edit', compact(['model', 'projectStatuses', 'projectPriorities', 'projectContractTypes', 'projectSources', 'currencies']));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'project_status_id' => 'required',
            'project_priority_id' => 'required',
            'project_contract_type_id' => 'required',
            'project_source_id' => 'required',
            "currency_id" => 'required',
            "flat_estimated_value" => 'numeric|nullable',
            "flat_negotiated_value" => 'numeric|nullable',
            "flat_accepted_value" => 'numeric|nullable'
        ]);

        if ($validator->fails()) {
            return redirect(route('projects.edit', ['id' => $id]))->withInput()->withErrors($validator->errors());
        }

        $model = Project::find($id);

        $data = [
            'name' => $request->name,
            'color' => $request->color ?? '#000000',
            'project_status_id' => json_decode($request->project_status_id)->id,
            'project_priority_id' => json_decode($request->project_priority_id)->id,
            'project_contract_type_id' => json_decode($request->project_contract_type_id)->id,
            'project_source_id' => $request->project_source_id
        ];

        $model->update($data);

        return redirect(route('projects.index'))->with('success', trans('translation.project.update'));
    }

    public function destroy($id)
    {
        $model = Project::find($id);
        $model->delete();

        return redirect(route('projects.index'))->with('success', trans('translation.project.destroy'));
    }

    public function addAction(Request $request, $id){
        $data = [
            'project_id' => $id,
            'description' => empty($request->description) ? 'No Action' : $request->description,
            'due_date' => empty($request->due_date) ? (new \DateTime())->format('Y-m-d') : $request->due_date,
            'status' => $request->status
        ];

        ProjectAction::create($data);

        $routeData = ['actions' => $id];
        if($request->has('view')){
            $routeData['view'] = $request->view;
        }

        return redirect(route('projects.index', $routeData))->with('success', trans('translation.project.projectActionAdded'));
    }

    public function addDocument(Request $request, $id){
        Document::create($request->all());

        $routeData = ['documents' => $id];
        if($request->has('view')){
            $routeData['view'] = $request->view;
        }

        return redirect(route('projects.index', $routeData))->with('success', trans('translation.project.projectActionAdded'));
    }

    public function updateActionStatus(Request $request, $id, $actionId)
    {
        $model = ProjectAction::where([
            'project_id' => $id,
            'id' => $actionId
        ])->first();

        $model->status = $request->status;
        $model->save();

        return redirect(route('projects.index', ['actions' => $id]))->with('success', trans('translation.project.projectActionStatusUpdated'));
    }

    public function quickSearch(Request $request)
    {
        $data = Project::where('name', 'like', '%'.$request->keyword.'%')->get();

        $results = [
            [
                'text' => "Select an option...",
                'id' => ''
            ]
        ];
        foreach ($data as $value){
            $results[] = [
                'text' => $value->name,
                'id' => $value->id
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
