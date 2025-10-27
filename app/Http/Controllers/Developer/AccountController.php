<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = Developer::where('status', 1)->get();
        return view('developer.accounts.index', compact('developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('developer.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_key' => 'nullable|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:developers,email',
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

        $developer = new Developer($request->only([
            'team_key', 'name', 'email', 'designation', 'gender',
            'phone_number', 'address', 'city', 'country',
            'postal_code', 'dob', 'about', 'status'
        ]));

        if ($request->hasFile('image')) {
            $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $publicPath = public_path('assets/images/developers');
            $request->file('image')->move($publicPath, $originalFileName);
            $developer->image = $originalFileName;
        }

        $developer->password = Hash::make(12345678);
        $developer->save();

        return redirect()->route('developer.account.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        return view('developer.accounts.show', compact('developer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Developer $developer)
    {
        return view('developer.accounts.edit', compact('developer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:developers,email,' . $developer->id,
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $developer->fill($request->only([
            'team_key', 'name', 'email', 'designation', 'gender',
            'phone_number', 'address', 'city', 'country',
            'postal_code', 'dob', 'about', 'status'
        ]));

        if ($request->hasFile('image')) {

            if ($developer->image) {
                if (!filter_var($developer->image, FILTER_VALIDATE_URL)) {
                    $path = public_path('assets/images/developers/' . $developer->image);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $publicPath = public_path('assets/images/developers');
            $request->file('image')->move($publicPath, $originalFileName);
            $developer->image = $originalFileName;
        }

        $developer->save();

        return redirect()->route('developer.account.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Developer $developer)
    {
        try {
            if ($developer->image) {
                if (!filter_var($developer->image, FILTER_VALIDATE_URL)) {
                    $path = public_path('assets/images/developers/' . $developer->image);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            if ($developer->delete()) {
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
    public function change_status(Request $request, Developer $developer)
    {
        try {
            if (!$developer->id) {
                return response()->json(['error' => 'Record not found. Please try again later.'], 404);
            }
            $developer->status = $request->query('status');
            $developer->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
