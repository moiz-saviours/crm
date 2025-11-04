<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.accounts.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_key' => 'nullable|max:255',
            'name' => 'required|string|max:255',
            'pseudo_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'pseudo_email' => 'nullable|email|max:255|unique:users,pseudo_email',
            'designation' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string',
            'pseudo_phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'about' => 'nullable|string',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'password' => 'nullable|string|max:255',
//            'phone_number' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20',
        ]);
        try {
            $admin = new Admin($request->only([
                'team_key', 'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
                'phone_number', 'pseudo_phone', 'address', 'city', 'country',
                'postal_code', 'dob', 'about', 'status'
            ]));
            if ($request->hasFile('image')) {
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $publicPath = public_path('assets/images/admins');
                $request->file('image')->move($publicPath, $originalFileName);
                $admin->image = $originalFileName;
            } else if ($request->image_url) {
                $admin->image = $request->image_url;
            }
            if ($request->has('password') && !empty($request->input('password'))) {
                $admin->password = Hash::make($request->input('password'));
            } else {
                $admin->password = Hash::make(12345678);
            }
            $admin->save();
            return response()->json(['data' => $admin, 'message' => 'Record created successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('admin.accounts.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            return response()->json($admin);
        }
        session(['edit_admin' => $admin]);
        return redirect()->route('admin.account.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pseudo_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'pseudo_email' => 'nullable|email|max:255|unique:users,pseudo_email,' . $admin->id,
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'phone_number' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20',
            'pseudo_phone' => 'nullable|string',
        ]);
        try {
            $admin->fill($request->only([
                'team_key', 'name', 'pseudo_name', 'email', 'pseudo_email', 'designation', 'gender',
                'phone_number', 'pseudo_phone', 'address', 'city', 'country',
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
            } else if ($request->image_url) {
                $admin->image = $request->image_url;
            }
            if ($request->has('password') && !empty($request->input('password'))) {
                $admin->password = Hash::make($request->input('password'));
            }
            $admin->save();
            return response()->json(['data' => $admin, 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Update password of specified resource in storage.
     */
    public function update_password(Request $request, Admin $admin)
    {
        $request->validate([
            'change_password' => 'required|string|max:255',
        ]);
        try {
            $admin->password = Hash::make($request->input('change_password'));
            $admin->save();
            $deletedSessions = $this->destroy_session($admin);
            Log::info("Password updated for User ID: {$admin->id}. Invalidated sessions: " . implode(', ', $deletedSessions));
            return response()->json(['data' => $admin,
                'message' => 'Password updated successfully. All active sessions have been invalidated.',
                'invalidated_sessions' => $deletedSessions,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
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
            $admin->status = 0;
            $admin->save();
            if ($admin->delete()) {
                $this->destroy_session($admin);
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
    public function change_status(Request $request, Admin $admin)
    {
        try {
            if (!$admin->id) {
                return response()->json(['error' => 'Record not found. Please try again later.'], 404);
            }
            $admin->status = $request->query('status');
            $admin->save();
            $this->destroy_session($admin);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Destroy all sessions and soft-delete verification codes for the given user.
     *
     * @param \App\Models\Admin $admin
     * @return array  $deletedSessions
     */
    protected function destroy_session(Admin $admin): array
    {
        $deletedSessions = [];
        try {
            $verificationCodes = $admin->verification_codes()->get();
            $sessionIds = $verificationCodes->whereNotNull('verified_at')->pluck('session_id')->toArray();
            foreach ($sessionIds as $sessionId) {
                $path = storage_path("framework/sessions/{$sessionId}");
                if (File::exists($path)) {
                    File::delete($path);
                    $deletedSessions[] = $sessionId;
                }
            }
            $admin->verification_codes()->whereNull('deleted_at')->update(['deleted_at' => now()]);
            return $deletedSessions;
        } catch (\Exception $e) {
            Log::error("Failed to destroy sessions for User ID: {$admin->id}. Error: {$e->getMessage()}", [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return [];
        }
    }
}
