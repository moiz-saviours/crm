<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('status', 1)->get();
        return view('developer.admin-accounts.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('developer.admin-accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_key' => 'nullable|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
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

        $admin = new Admin($request->only([
            'team_key', 'name', 'email', 'designation', 'gender',
            'phone_number', 'address', 'city', 'country',
            'postal_code', 'dob', 'about', 'status'
        ]));

        if ($request->hasFile('image')) {
            $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $publicPath = public_path('assets/images/accounts');
            $request->file('image')->move($publicPath, $originalFileName);
            $admin->image = $originalFileName;
        }

        $admin->password = Hash::make(12345678);
        $admin->save();

        return redirect()->route('developer.admin.account.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('developer.admin-accounts.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('developer.admin-accounts.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $admin->fill($request->only([
            'team_key', 'name', 'email', 'designation', 'gender',
            'phone_number', 'address', 'city', 'country',
            'postal_code', 'dob', 'about', 'status'
        ]));

        if ($request->hasFile('image')) {

            if ($admin->image) {
                if (!filter_var($admin->image, FILTER_VALIDATE_URL)) {
                    $path = public_path('assets/images/admins/' . $admin->image);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $publicPath = public_path('assets/images/admins');
            $request->file('image')->move($publicPath, $originalFileName);
            $admin->image = $originalFileName;
        }

        $admin->save();

        return redirect()->route('developer.admin.account.index')->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Admin $admin)
    {
        try {
            if ($admin->image) {
                if (!filter_var($admin->image, FILTER_VALIDATE_URL)) {
                    $path = public_path('assets/images/admins/' . $admin->image);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            if ($admin->delete()) {
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
    public function change_status(Request $request, Admin $admin)
    {
        try {
            if (!$admin->id) {
                return response()->json(['error' => 'Record not found. Please try again later.'], 404);
            }
            $admin->status = $request->query('status');
            $admin->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
