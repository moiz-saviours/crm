<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Models\UserPseudoRecord;
use App\Traits\ForceLogoutTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserEmployeeController extends Controller
{
    use ForceLogoutTrait;
    public function index()
    {

        $teams = Team::whereStatus(1)->get();
        $positions = Position::all();

        $isItExecutive = auth()->user()?->department?->name === 'Operations'
            && auth()->user()?->role?->name === 'IT Executive';

        if ($isItExecutive){

            // Restrict IT Executive (Operations) to Sales users only
            $allowRoles = [40, 41, 42, 43, 44, 45, 46, 47];
            $allowDepartments = [5];

            $users = User::whereIn('role_id', $allowRoles)
                ->whereIn('department_id', $allowDepartments)
                ->get(['id','department_id', 'role_id', 'position_id', 'emp_id',
                'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
                'date_of_joining', 'about', 'status']);

            $departments = Department::whereIn('id', $allowDepartments)->get();
            $roles = Role::whereIn('id', $allowRoles)->get();

        } else {
            $users = User::get(['id','department_id', 'role_id', 'position_id', 'emp_id',
                'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
                'phone_number', 'pseudo_phone', 'address', 'city', 'state', 'country',
                'postal_code', 'dob', 'date_of_joining', 'about', 'target', 'status']);
            $departments = Department::all();
            $roles = Role::all();
        }

        return view('user.employees.index', compact('teams', 'users', 'departments', 'roles', 'positions'));
    }


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
            'pseudo_name.required' => 'The main pseudo name is required if extra pseudos are present.',
            // Email
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'The email has already been taken.',
            // Pseudo Email
            'pseudo_email.email' => 'The pseudo email must be a valid email address.',
            'pseudo_email.max' => 'The pseudo email must not exceed 255 characters.',
            'pseudo_email.unique' => 'The pseudo email has already been taken.',
            'pseudo_email.required' => 'The main pseudo email is required if extra pseudos are present.',
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
            'extra_pseudos.array' => 'The extra pseudos must be an array.',
            'extra_pseudos.*.pseudo_name.string' => 'Each extra pseudo name must be a string.',
            'extra_pseudos.*.pseudo_name.max' => 'Each extra pseudo name must not exceed 255 characters.',
            'extra_pseudos.*.pseudo_email.required' => 'Each extra pseudo email must be required.',
            'extra_pseudos.*.pseudo_email.email' => 'Each extra pseudo email must be valid.',
            'extra_pseudos.*.pseudo_email.max' => 'Each extra pseudo email must not exceed 255 characters.',
            'extra_pseudos.*.pseudo_email.unique' => 'Pseudo email has already been taken.',
            'extra_pseudos.*.pseudo_phone.string' => 'Each extra pseudo phone must be a string.',
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
//            'pseudo_email' => 'nullable|email|max:255|unique:users,pseudo_email',
            'pseudo_email' => [
                'nullable',
                'email',
                'max:255',
                'unique:users,email',
                'unique:users,pseudo_email',
                Rule::unique('user_pseudo_records', 'pseudo_email'),
            ],
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
            'extra_pseudos' => 'nullable|array',
            'extra_pseudos.*.pseudo_name' => 'nullable|string|max:255',
            'extra_pseudos.*.pseudo_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                Rule::unique('users', 'pseudo_email'),
                Rule::unique('user_pseudo_records', 'pseudo_email'),
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $allExtraEmails = collect($request->input('extra_pseudos', []))->pluck('pseudo_email')->filter()->toArray();
                        $occurrences = array_count_values($allExtraEmails);
                        if (isset($occurrences[$value]) && $occurrences[$value] > 1) {
                            $fail('The pseudo email "' . $value . '" is duplicated in your input.');
                        }
                        $mainPseudoEmail = $request->input('pseudo_email');
                        if ($value === $mainPseudoEmail) {
                            $fail('The pseudo email "' . $value . '" cannot be the same as the main pseudo email.');
                        }
                    }
                },
            ],
            'extra_pseudos.*.pseudo_phone' => 'nullable|string|max:20',
        ], $messages);

        if (auth()->user()->department->name == "Operations" && auth()->user()->role->name == 'IT Executive') {
            $allowRoles = [40, 41, 42, 43, 44, 45, 46, 47];
            $allowDepartments = [5];

            if (!in_array($request->role_id, $allowRoles)) {
                return response()->json(['error' => ' Unauthorize Access', 'message' => 'Invalid role selection.'], 422);

            }

            if (!in_array($request->department_id, $allowDepartments)) {
                return response()->json(['error' => ' Unauthorize Access', 'message' => 'Invalid department selection.'], 422);
            }
        }

        if ($request->filled('extra_pseudos')) {
            $request->validate([
                'pseudo_name' => 'required|string|max:255',
                'pseudo_email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                    'unique:users,pseudo_email',
                    Rule::unique('user_pseudo_records', 'pseudo_email'),
                ],
            ], [
                'pseudo_name.required' => 'The main pseudo name is required if extra pseudos exist.',
                'pseudo_email.required' => 'The main pseudo email is required if extra pseudos exist.',
            ]);
        }
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
            if ($request->filled('extra_pseudos')) {
                foreach ($request->input('extra_pseudos') as $pseudo) {
                    if (!empty($pseudo['pseudo_email'])) {
                        $user->pseudo_records()->create([
                            'pseudo_name' => $pseudo['pseudo_name'] ?? null,
                            'pseudo_email' => $pseudo['pseudo_email'] ?? null,
                            'pseudo_phone' => $pseudo['pseudo_phone'] ?? null,
                            'creator_type' => get_class(auth()->user()),
                            'creator_id' => auth()->id(),
                        ]);
                    }
                }
            }
            if ($request->has('team_key') && !empty($request->input('team_key'))) {
                $user->teams()->sync($request->input('team_key'));
            }
            $teamNames = $user->teams->pluck('name')->map('htmlspecialchars_decode')->implode(', ');
            return response()->json(['data' => array_merge($user->toArray(), ['team_name' => $teamNames]), 'message' => 'Record created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function edit(Request $request, $id)
    {

        $isItExecutive = auth()->user()?->department?->name === 'Operations'
            && auth()->user()?->role?->name === 'IT Executive';

        $teams = Team::whereStatus(1)->get();

        if ($isItExecutive) {
            $allowRoles = [40, 41, 42, 43, 44, 45, 46, 47];
            $allowDepartments = [5];

            $user = User::whereIn('role_id', $allowRoles)
                ->whereIn('department_id', $allowDepartments)
                ->findOrFail($id, [
                    'id','department_id','role_id','position_id','emp_id',
                    'name','pseudo_name','email','pseudo_email','designation',
                    'gender','date_of_joining','about','status'
                ]);
            $departments = Department::whereIn('id', $allowDepartments)->get();
            $roles = Role::whereIn('id', $allowRoles)->get();

        } else {
            $user = User::findOrFail($id, [
                'id','department_id','role_id','position_id','emp_id',
                'name','pseudo_name','email','pseudo_email','designation','gender',
                'phone_number','pseudo_phone','address','city','state','country',
                'postal_code','dob','date_of_joining','about','target','status'
            ]);
            $departments = Department::get();
            $roles = Role::get();
        }

        $teams = Team::whereStatus(1)->get();

        $firstTeam = $user->teams()
            ->select('teams.id', 'teams.name', 'teams.status', 'teams.team_key')
            ->first();

        $user->team_key = $firstTeam ? $firstTeam->team_key : null;
        $user->load('pseudo_records');

        if ($request->ajax()) {
            return response()->json([
                'user' => $user,
                'teams' => $teams,
                'departments' => $departments,
                'roles' => $roles,
                'extra_pseudos' => $user->pseudo_records
            ]);
        }


        return view('user.employees.edit', compact('user', 'teams', 'departments', 'roles', 'isItExecutive'));
    }




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
            'pseudo_name.required' => 'The main pseudo name is required if extra pseudos are present.',
            // Email
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'The email has already been taken.',
            // Pseudo Email
            'pseudo_email.email' => 'The pseudo email must be a valid email address.',
            'pseudo_email.max' => 'The pseudo email must not exceed 255 characters.',
            'pseudo_email.unique' => 'The pseudo email has already been taken.',
            'pseudo_email.required' => 'The main pseudo email is required if extra pseudos are present.',
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
            'extra_pseudos.array' => 'The extra pseudos must be an array.',
            'extra_pseudos.*.pseudo_name.string' => 'Each extra pseudo name must be a string.',
            'extra_pseudos.*.pseudo_name.max' => 'Each extra pseudo name must not exceed 255 characters.',
            'extra_pseudos.*.pseudo_email.required' => 'Each extra pseudo email must be required.',
            'extra_pseudos.*.pseudo_email.email' => 'Each extra pseudo email must be valid.',
            'extra_pseudos.*.pseudo_email.max' => 'Each extra pseudo email must not exceed 255 characters.',
            'extra_pseudos.*.pseudo_email.unique' => 'Pseudo email has already been taken.',
            'extra_pseudos.*.pseudo_phone.string' => 'Each extra pseudo phone must be a string.',
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
            'pseudo_email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('users', 'pseudo_email')->ignore($user->id ?? null),
                Rule::unique('user_pseudo_records', 'pseudo_email')
            ],
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
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
            'extra_pseudos' => 'nullable|array',
            'extra_pseudos.*.pseudo_name' => 'nullable|string|max:255',
            'extra_pseudos.*.pseudo_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                Rule::unique('users', 'pseudo_email'),
                function ($attribute, $value, $fail) use ($request, $user) {
                    if ($value) {
                        $allExtraEmails = collect($request->input('extra_pseudos', []))->pluck('pseudo_email')->filter()->toArray();
                        $occurrences = array_count_values($allExtraEmails);
                        if (isset($occurrences[$value]) && $occurrences[$value] > 1) {
                            $fail('The pseudo email "' . $value . '" is duplicated in your input.');
                        }
                        $mainPseudoEmail = $request->input('pseudo_email');
                        if ($value === $mainPseudoEmail) {
                            $fail('The pseudo email "' . $value . '" cannot be the same as the main pseudo email.');
                        }
                        $exists = UserPseudoRecord::where('pseudo_email', $value)->where('user_id', '!=', $user->id)->exists();
                        if ($exists) {
                            $fail('The pseudo email "' . $value . '" has already been taken by another user.');
                        }
                    }
                },
            ],
            'extra_pseudos.*.pseudo_phone' => 'nullable|string|max:20',
//            'phone_number' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
        ], $messages);

        if (auth()->user()->department->name == "Operations" && auth()->user()->role->name == 'IT Executive') {

            $allowRoles = [40, 41, 42, 43, 44, 45, 46, 47];
            $allowDepartments = [5];

            if (!in_array($request->role_id, $allowRoles)) {
                return response()->json(['error' => ' Unauthorized Access', 'message' => 'Invalid role selection.'], 422);

            }

            if (!in_array($request->department_id, $allowDepartments)) {
                return response()->json(['error' => ' Unauthorized Access', 'message' => 'Invalid department selection.'], 422);
            }
        }

        if ($request->filled('extra_pseudos')) {
            $request->validate([
                'pseudo_name' => 'required|string|max:255',
                'pseudo_email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'),
                    Rule::unique('users', 'pseudo_email')->ignore($user->id ?? null),
                    Rule::unique('user_pseudo_records', 'pseudo_email'),
                ],
            ], [
                'pseudo_name.required' => 'The main pseudo name is required if extra pseudos exist.',
                'pseudo_email.required' => 'The main pseudo email is required if extra pseudos exist.',
            ]);
        }
        try {
            $user->fill($request->only([
                'department_id', 'role_id', 'position_id', 'team_key', 'emp_id',
                'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
                'phone_number', 'pseudo_phone', 'address', 'city', 'state', 'country',
                'postal_code', 'dob', 'date_of_joining', 'about', 'target', 'status'
            ]));
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
            if ($request->filled('extra_pseudos')) {
                $emailsToKeep = [];
                foreach ($request->input('extra_pseudos') as $pseudo) {
                    $pseudoEmail = $pseudo['pseudo_email'];
                    $existingRecord = $user->pseudo_records()->where('pseudo_email', $pseudoEmail)->first();
                    if ($existingRecord) {
                        $existingRecord->update([
                            'pseudo_name' => $pseudo['pseudo_name'] ?? $existingRecord->pseudo_name,
                            'pseudo_phone' => $pseudo['pseudo_phone'] ?? $existingRecord->pseudo_phone,
                            'updater_type' => get_class(auth()->user()),
                            'updater_id' => auth()->id(),
                        ]);
                    } else {
                        $user->pseudo_records()->create([
                            'pseudo_name' => $pseudo['pseudo_name'] ?? null,
                            'pseudo_email' => $pseudoEmail,
                            'pseudo_phone' => $pseudo['pseudo_phone'] ?? null,
                            'creator_type' => get_class(auth()->user()),
                            'creator_id' => auth()->id(),
                        ]);
                    }
                    $emailsToKeep[] = $pseudoEmail;
                }
                if (!empty($emailsToKeep)) {
                    $user->pseudo_records()->whereNotIn('pseudo_email', $emailsToKeep)->delete();
                } else {
                    $user->pseudo_records()->delete();
                }
            } else {
                $user->pseudo_records()->delete();
            }
            if ($request->has('team_key') && !empty($request->input('team_key'))) {
                $user->teams()->sync($request->input('team_key'));
            }
            $teamNames = $user->teams->pluck('name')->map('htmlspecialchars_decode')->implode(', ');
            $this->forceLogoutUser($user);
            return response()->json(['data' => array_merge($user->toArray(), ['team_name' => $teamNames]), 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function update_password(Request $request, User $user)
    {
        $request->validate([
            'change_password' => 'required|string|max:255',
        ]);
        try {
            $user->password = Hash::make($request->input('change_password'));
            $user->save();
            $this->forceLogoutUser($user);
            return response()->json(['data' => $user,
                'message' => 'Password updated successfully. All active sessions have been invalidated.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
    public function change_status(Request $request, User $user)
    {
        try {
            if (!$user->id) {
                return response()->json(['error' => 'Record not found. Please try again later.'], 404);
            }
            $user->status = $request->query('status');
            $user->save();
            $this->forceLogoutUser($user);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
