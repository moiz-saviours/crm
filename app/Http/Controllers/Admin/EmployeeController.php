<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignTeamMember;
use App\Models\Department;
use App\Models\Position;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::whereStatus(1)->get();
        $users = User::all();
        $departments = Department::whereIn('name', ['Sales', 'Operations'])->get();
        $roles = Role::whereHas('department', function ($query) {
            $query->where('name', 'Sales');
        })
            ->orWhere(function ($query) {
                $query->whereHas('department', function ($q) {
                    $q->where('name', 'Operations');
                })
                    ->where('name', 'Accounts');
            })
            ->get();
        $positions = Position::all();
        return view('admin.employees.index', compact('teams', 'users', 'departments', 'roles', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            // Department ID
            'department_id.required' => 'The department field is required.',
            'department_id.integer' => 'The department must be a valid ID.',
            'department_id.exists' => 'The selected department is invalid.',
            // Role ID
            'role_id.required' => 'The role field is required.',
            'role_id.integer' => 'The role must be a valid ID.',
            'role_id.exists' => 'The selected role is invalid.',
            // Position ID
            'position_id.required' => 'The position field is required.',
            'position_id.integer' => 'The position must be a valid ID.',
            'position_id.exists' => 'The selected position is invalid.',
            // Team Key
            'team_key.integer' => 'The team must be a valid number.',
            'team_key.exists' => 'The selected team is invalid.',
            // Employee ID
            'emp_id.string' => 'The employee ID must be a string.',
            'emp_id.max' => 'The employee ID must not exceed 255 characters.',
            // Name
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',
            // Pseudo Name
            'pseudo_name.string' => 'The pseudo name must be a string.',
            'pseudo_name.max' => 'The pseudo name must not exceed 255 characters.',
            // Email
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'The email has already been taken.',
            // Pseudo Email
            'pseudo_email.email' => 'The pseudo email must be a valid email address.',
            'pseudo_email.max' => 'The pseudo email must not exceed 255 characters.',
            'pseudo_email.unique' => 'The pseudo email has already been taken.',
            // Designation
            'designation.string' => 'The designation must be a string.',
            'designation.max' => 'The designation must not exceed 255 characters.',
            // Image
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image must not exceed 2048 kilobytes.',
            // Target
            'target.integer' => 'The target must be an integer.',
            // Status
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either 0 or 1.',
            // Password
            'password.string' => 'The password must be a string.',
            'password.max' => 'The password must not exceed 255 characters.',
            // Gender
            'gender.string' => 'The gender must be a string.',
            'gender.max' => 'The gender must not exceed 10 characters.',
            // Phone Number
            'phone_number.string' => 'The phone number must be a string.',
            // Pseudo Phone
            'pseudo_phone.string' => 'The pseudo phone must be a string.',
            // Address
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address must not exceed 255 characters.',
            // City
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city must not exceed 255 characters.',
            // State
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state must not exceed 255 characters.',
            // Country
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country must not exceed 255 characters.',
            // Postal Code
            'postal_code.string' => 'The postal code must be a string.',
            'postal_code.max' => 'The postal code must not exceed 10 characters.',
            // Date of Birth
            'dob.date' => 'The date of birth must be a valid date.',
            // Date of Joining
            'date_of_joining.date' => 'The date of joining must be a valid date.',
            // About
            'about.string' => 'The about field must be a string.',
        ];
        $request->validate([
            'department_id' => 'nullable|integer|exists:departments,id',
            'role_id' => 'nullable|integer|exists:roles,id',
            'position_id' => 'nullable|integer|exists:positions,id',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'emp_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'pseudo_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'pseudo_email' => 'nullable|email|max:255|unique:users,pseudo_email',
            'designation' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string',
            'pseudo_phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'date_of_joining' => 'nullable|date',
            'about' => 'nullable|string',
            'target' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|max:255',
//            'phone_number' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
        ], $messages);
        try {

            $user = new User($request->only([
                'department_id', 'role_id', 'position_id', 'team_key', 'emp_id',
                'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
                'phone_number', 'pseudo_phone', 'address', 'city', 'state', 'country',
                'postal_code', 'dob', 'date_of_joining', 'about', 'target', 'status'
            ]));
            if ($request->hasFile('image')) {
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $publicPath = public_path('assets/images/employees');
                $request->file('image')->move($publicPath, $originalFileName);
                $user->image = $originalFileName;
            }
            if ($request->has('password') && !empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            } else {
                $user->password = Hash::make(12345678);
            }
            $user->save();
            if ($request->has('team_key') && !empty($request->input('team_key'))) {
                $user->teams()->sync($request->input('team_key'));
            }
            $teamNames = $user->teams->pluck('name')->map('htmlspecialchars_decode')->implode(', ');
            return response()->json(['data' => array_merge($user->toArray(), ['team_name' => $teamNames]), 'message' => 'Record created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        $teams = Team::whereStatus(1)->get();
        $firstTeam = $user->teams->first();
        $user->team_key = $firstTeam ? $firstTeam->team_key : null;
        if ($request->ajax()) {
            return response()->json(['user' => $user, 'teams' => $teams]);
        }
        return view('admin.employees.edit', compact('user', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $messages = [
            // Department ID
            'department_id.required' => 'The department field is required.',
            'department_id.integer' => 'The department must be a valid ID.',
            'department_id.exists' => 'The selected department is invalid.',
            // Role ID
            'role_id.required' => 'The role field is required.',
            'role_id.integer' => 'The role must be a valid ID.',
            'role_id.exists' => 'The selected role is invalid.',
            // Position ID
            'position_id.required' => 'The position field is required.',
            'position_id.integer' => 'The position must be a valid ID.',
            'position_id.exists' => 'The selected position is invalid.',
            // Team Key
            'team_key.integer' => 'The team must be a valid number.',
            'team_key.exists' => 'The selected team is invalid.',
            // Employee ID
            'emp_id.string' => 'The employee ID must be a string.',
            'emp_id.max' => 'The employee ID must not exceed 255 characters.',
            // Name
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',
            // Pseudo Name
            'pseudo_name.string' => 'The pseudo name must be a string.',
            'pseudo_name.max' => 'The pseudo name must not exceed 255 characters.',
            // Email
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'The email has already been taken.',
            // Pseudo Email
            'pseudo_email.email' => 'The pseudo email must be a valid email address.',
            'pseudo_email.max' => 'The pseudo email must not exceed 255 characters.',
            'pseudo_email.unique' => 'The pseudo email has already been taken.',
            // Designation
            'designation.string' => 'The designation must be a string.',
            'designation.max' => 'The designation must not exceed 255 characters.',
            // Image
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image must not exceed 2048 kilobytes.',
            // Target
            'target.integer' => 'The target must be an integer.',
            // Status
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either 0 or 1.',
            // Password
            'password.string' => 'The password must be a string.',
            'password.max' => 'The password must not exceed 255 characters.',
            // Gender
            'gender.string' => 'The gender must be a string.',
            'gender.max' => 'The gender must not exceed 10 characters.',
            // Phone Number
            'phone_number.string' => 'The phone number must be a string.',
            // Pseudo Phone
            'pseudo_phone.string' => 'The pseudo phone must be a string.',
            // Address
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address must not exceed 255 characters.',
            // City
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city must not exceed 255 characters.',
            // State
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state must not exceed 255 characters.',
            // Country
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country must not exceed 255 characters.',
            // Postal Code
            'postal_code.string' => 'The postal code must be a string.',
            'postal_code.max' => 'The postal code must not exceed 10 characters.',
            // Date of Birth
            'dob.date' => 'The date of birth must be a valid date.',
            // Date of Joining
            'date_of_joining.date' => 'The date of joining must be a valid date.',
            // About
            'about.string' => 'The about field must be a string.',
        ];
        $request->validate([
            'department_id' => 'nullable|integer|exists:departments,id',
            'role_id' => 'nullable|integer|exists:roles,id',
            'position_id' => 'nullable|integer|exists:positions,id',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'emp_id' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'pseudo_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'pseudo_email' => 'nullable|email|max:255|unique:users,pseudo_email,' . $user->id,
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'password' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string',
            'pseudo_phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'date_of_joining' => 'nullable|date',
            'about' => 'nullable|string',
//            'phone_number' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
        ], $messages);
        $user->fill($request->only([
            'department_id', 'role_id', 'position_id', 'team_key', 'emp_id',
            'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
            'phone_number', 'pseudo_phone', 'address', 'city', 'state', 'country',
            'postal_code', 'dob', 'date_of_joining', 'about', 'target', 'status'
        ]));
        try {

            if ($request->hasFile('image')) {

                if ($user->image) {
                    if (!filter_var($user->image, FILTER_VALIDATE_URL)) {
                        $path = public_path('assets/images/employees/' . $user->image);
                        if (File::exists($path)) {
//                        File::delete($path);
                        }
                    }
                }
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $publicPath = public_path('assets/images/employees');
                $request->file('image')->move($publicPath, $originalFileName);
                $user->image = $originalFileName;
            }
            if ($request->has('password') && !empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
            if ($request->has('team_key') && !empty($request->input('team_key'))) {
                $user->teams()->sync($request->input('team_key'));
            }
            $teamNames = $user->teams->pluck('name')->map('htmlspecialchars_decode')->implode(', ');
            return response()->json(['data' => array_merge($user->toArray(), ['team_name' => $teamNames]), 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        try {
            if ($user->image) {
                if (!filter_var($user->image, FILTER_VALIDATE_URL)) {
                    $path = public_path('assets/images/employees/' . $user->image);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            if ($user->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Update password of specified resource in storage.
     */
    public function update_password(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|max:255',
        ]);
        try {
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json(['data' => $user, 'message' => 'Record password updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, User $user)
    {
        try {
            if (!$user->id) {
                return response()->json(['error' => 'Record not found. Please try again later.'], 404);
            }
            $user->status = $request->query('status');
            $user->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
