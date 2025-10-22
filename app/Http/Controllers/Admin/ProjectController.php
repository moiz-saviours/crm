<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function getProjectsData(Request $request)
    {
        $query = Project::where('id',$request->customer_id)->withCount(['attachments', 'members'])
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
        $project = Project::where('id',$request->customer_id)->with(['attachments', 'members'])
                         ->withCount(['attachments', 'members'])
                         ->find($request->id);
        
        return view('admin.customers.contacts.timeline.partials.project.partials.project-details', compact('project'));
    }
}
