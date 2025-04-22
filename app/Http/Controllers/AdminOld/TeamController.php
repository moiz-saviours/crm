<?php

namespace App\Http\Controllers\AdminOld;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the teams.
     */
    public function index()
    {
        $teams = Team::where('status', 1)->orderBy('name')->get();
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team.
     */
    public function create()
    {
        try {
            $brands = Brand::where('status', 1)->orderBy('name')->get();
            $users = User::where('status', 1)->orderBy('name')->get();
            return view('admin-old.teams.create', compact('brands', 'users'));
        } catch (\Exception $e) {
            return redirect()->route('admin.team.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['status' => $request->has('status') & $request->get('status') == "on" ? 1 : 0]);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|integer|in:0,1',
            'lead_id' => 'nullable|exists:users,id',
            'employees' => 'nullable|array',
            'employees.*' => 'exists:users,id',
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,brand_key',
        ], [
            'name.required' => 'The team name is required.',
            'name.string' => 'The team name must be a valid string.',
            'name.max' => 'The team name may not be greater than 255 characters.',

            'description.string' => 'The description must be a valid string.',

            'status.required' => 'The team status is required.',
            'status.integer' => 'The team status must be an integer.',
            'status.in' => 'The team status must be either 0 (inactive) or 1 (active).',

            'lead_id.exists' => 'The selected team lead is invalid.',

            'employees.array' => 'Team members must be selected as an array.',
            'employees.*.exists' => 'One or more selected team members are invalid.',
            'brands.array' => 'Brands must be selected as an array.',
            'brands.*.exists' => 'One or more selected brands are invalid.',
        ]);


        $team = new Team($request->only(['name', 'description', 'status']));
        $team->save();

        if ($request->has('lead_id')) {
            $team->lead_id = $request->lead_id;
            $team->save();
        }
//        $team->update(['team_key' => $team->generateTeamKey($team->id)]);
        if ($request->has('employees')) {
            $team->users()->sync($request->employees);
            if ($request->has('lead_id') && !in_array($request->lead_id, $request->employees)) {
                $team->users()->attach($request->lead_id);
            }
        }

        if ($request->has('brands')) {
            $team->brands()->sync($request->brands);
        }

        return redirect()->route('admin.team.edit', [$team->id])->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit(Team $team)
    {
        try {
            if (!$team->id) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'Oops! Record not found.']);
                }
                return redirect()->route('admin.team.index')->with('error', 'Team not found.');
            }
            $brands = Brand::where('status', 1)->orderBy('name')->get();
            $users = User::where('status', 1)->orderBy('name')->get();
            if (request()->ajax()) {
                $assign_brands = $team->brands->pluck('name')->map('htmlspecialchars_decode')->implode(', ');
                return response()->json(['data' => array_merge($team->toArray(), ['assign_brands' => $assign_brands]), 'message' => 'Record updated successfully.']);
            }
            $teamEmployees = $team->users->pluck('id')->toArray();
            $teamBrands = $team->brands->pluck('brand_key')->toArray();
            return view('admin.teams.edit', compact('team', 'brands', 'users', 'teamEmployees', 'teamBrands'));

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
            }
            return redirect()->route('admin.team.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified team in storage.
     */
    public function update(Request $request, Team $team)
    {
        $request->merge(['status' => $request->has('status') & $request->get('status') == "on" ? 1 : 0]);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'integer|in:0,1',
            'lead_id' => 'nullable|exists:users,id',
            'employees' => 'nullable|array',
            'employees.*' => 'exists:users,id',
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,brand_key',
        ]);

        $employees = $request->input('employees', []);
        $team->update($request->only(['name', 'description', 'status', 'lead_id']));
        $team->save();
        if ($request->has('lead_id') && !empty($request->get('lead_id')) && !in_array($request->lead_id, $employees)) {
            $employees[] = $request->lead_id;
        }
        $team->users()->sync($employees);
        $team->brands()->sync($request->input('brands', []));

        if (request()->ajax()) {
            $assign_brands = $team->brands->pluck('name')->map('htmlspecialchars_decode')->implode(', ');
            return response()->json(['data' => array_merge($team->toArray(), ['assign_brands' => $assign_brands]), 'message' => 'Record updated successfully.']);
        }
        return redirect()->route('admin.team.edit', [$team->id])->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Team $team)
    {
        try {
            if ($team->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, Team $team)
    {
        try {
            $team->status = $request->query('status');
            $team->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
