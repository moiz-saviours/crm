<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leadStatus = LeadStatus::where('status', 1)->get();
        return view('developer.lead-statuses.index', compact('leadStatus'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('developer.lead-statuses.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:lead_statuses,name,' . ($leadStatus->id ?? 'NULL') . '|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
            'color' => 'nullable|string|hex_color',
        ]);

        try {
            $leadStatus = LeadStatus::create($validated);
            return response()->json(['data' => $leadStatus, 'message' => 'Lead Status created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(LeadStatus $leadStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, LeadStatus $leadStatus)
    {
        if ($request->ajax()) {
            return response()->json($leadStatus);
        }
        session(['edit_leadStatus' => $leadStatus]);
        return redirect()->route('developer.lead-statuses.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadStatus $leadStatus)
    {
        $validated = $request->validate([
            'name' => 'required|unique:lead_statuses,name,' . ($leadStatus->id ?? 'NULL') . '|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
            'color' => 'nullable|string|hex_color',
        ]);

        try {
            $leadStatus->update($validated);
            return response()->json(['data' => $leadStatus, 'message' => 'Lead Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(LeadStatus $leadStatus)
    {
        try {
            if ($leadStatus->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'Unable to process deletion request at this time.'], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, LeadStatus $leadStatus)
    {
        try {
            $leadStatus->status = $request->query('status');
            $leadStatus->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
