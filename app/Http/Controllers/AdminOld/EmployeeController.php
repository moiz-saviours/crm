<?php

namespace App\Http\Controllers\AdminOld;

use App\Http\Controllers\Controller;
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
        $users = User::where('status', 1)->orderBy('name')->get();
        return view('admin.employees.index', compact('users'));
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
        $request->validate([
            'team_key' => 'nullable|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'designation' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'about' => 'nullable|string',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {

            $user = new User($request->only([
                'team_key', 'name', 'email', 'designation', 'gender',
                'phone_number', 'address', 'city', 'country',
                'postal_code', 'dob', 'about', 'status'
            ]));

            if ($request->hasFile('image')) {
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $publicPath = public_path('assets/images/employees');
                $request->file('image')->move($publicPath, $originalFileName);
                $user->image = $originalFileName;
            }

            $user->password = Hash::make(12345678);
            $user->save();

            return response()->json(['data' => $user, 'message' => 'Record created successfully.']);

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
        if ($request->ajax()) {
            return response()->json($user);
        }
        return view('admin.employees.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $user->fill($request->only([
            'team_key', 'name', 'email', 'designation', 'gender',
            'phone_number', 'address', 'city', 'country',
            'postal_code', 'dob', 'about', 'status'
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

            $user->save();
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
            return response()->json(['error' => 'Unable to process deletion request at this time.'], 422);

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
