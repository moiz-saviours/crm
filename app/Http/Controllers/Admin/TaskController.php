<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function getTasksData(Request $request)
    {
        $query = Task::whereHas('project', function($q) use ($request) {
                    $q->where('cus_contact_key', $request->cus_contact_key);
                })
                ->withCount(['attachments', 'members'])
                ->with(['attachments', 'members', 'project']);
        // Apply filters
        if ($request->status) {
            $query->where('task_status', $request->status);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('label', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('special_key', 'like', "%{$request->search}%");
            });
        }
        
        $tasks = $query->get();
        
        return view('admin.customers.contacts.timeline.partials.task.partials.task-data', compact('tasks'));
    }

    public function getTaskDetails(Request $request)
    {
        $task = Task::whereHas('project', function($q) use ($request) {
                    $q->where('cus_contact_key', $request->cus_contact_key);
                })
                ->with(['attachments', 'members', 'project'])
                ->withCount(['attachments', 'members'])
                ->find($request->id);
        
        return view('admin.customers.contacts.timeline.partials.task.partials.task-details', compact('task'));
    }

    public function updateTaskMove(Request $request)
    {
        try {
            Log::info('Updating task move', $request->all());
            
            $taskId = $request->task_id;
            $newStatus = $request->new_status;
            $taskIds = $request->task_ids;

            // Validate required fields
            if (!$taskId || !$newStatus) {
                return response()->json([
                    'success' => false,
                    'error' => 'Missing required fields'
                ]);
            }

            // Update task status
            $task = Task::find($taskId);
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'error' => 'Task not found'
                ]);
            }

            $task->update([
                'task_status' => $newStatus
            ]);

            // Update order if task IDs are provided
            if ($taskIds && is_array($taskIds)) {
                foreach ($taskIds as $order => $id) {
                    Task::where('id', $id)->update([
                        'order_column' => $order
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Task moved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating task move: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}