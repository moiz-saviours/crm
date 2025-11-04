<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class ProjectController extends Controller
{

    public function getProjectsData(Request $request)
    {
        $query = Project::where('cus_contact_key',$request->cus_contact_key)->withCount(['attachments', 'members'])
                        ->with(['attachments', 'members']);
        
        // Apply filters
        if ($request->status) {
            $query->where('project_status', $request->status);
        }
        
        if ($request->value) {
            $query->where('value', $request->value);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('label', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('special_key', 'like', "%{$request->search}%");
            });
        }
        
        $projects = $query->get();
        
        return view('admin.customers.contacts.timeline.partials.project.partials.project-data', compact('projects'));
    }

    public function getProjectDetails(Request $request)
    {
        $project = Project::where('cus_contact_key',$request->cus_contact_key)->with(['attachments', 'members'])
                         ->withCount(['attachments', 'members'])
                         ->find($request->id);
        
        return view('admin.customers.contacts.timeline.partials.project.partials.project-details', compact('project'));
    }

public function updateProjectMove(Request $request)
{
    try {
        Log::info('Updating project move', $request->all());
        
        $projectId = $request->project_id;
        $newStatus = $request->new_status;
        $projectIds = $request->project_ids;

        // Validate required fields
        if (!$projectId || !$newStatus) {
            return response()->json([
                'success' => false,
                'error' => 'Missing required fields'
            ]);
        }

        // Update project status
        $project = Project::find($projectId);
        if (!$project) {
            return response()->json([
                'success' => false,
                'error' => 'Project not found'
            ]);
        }

        $project->update([
            'project_status' => $newStatus
        ]);

        // Update order if project IDs are provided
        if ($projectIds && is_array($projectIds)) {
            foreach ($projectIds as $order => $id) {
                Project::where('id', $id)->update([
                    'order_column' => $order
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Project moved successfully'
        ]);

    } catch (\Exception $e) {
        Log::error('Error updating project move: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
}
