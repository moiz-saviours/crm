<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use function view;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $messages = [
            'name.string' => 'The name must be a string.',
            'name.max' => 'The first name must not exceed 255 characters.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.string' => 'The phone number must be a string.',
            'phone_number.max' => 'The phone number must not exceed 20 characters.',
        ];
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:admins,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ], $messages);
        try {

            $user->name = $validatedData['name'] ?? $user->name;
//            if ($user->isDirty('email')) {
//                $user->email_verified_at = null;
//            }
            $user->email = $validatedData['email'] ?? $user->email;
            $user->phone_number = $validatedData['phone_number'] ?? $user->phone_number;
            $user->save();
            return response()->json([
                'data' => [
                    'user' => $user->fresh(),
                ],
                'message' => 'Profile updated successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'Failed to update profile. Please try again.'
            ], 500);
        }
    }

    /**
     * Update the user's profile image.
     */
    public function image_update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);
        try {
            if ($request->hasFile('image')) {
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $publicPath = public_path('assets/images/admins');
                $request->file('image')->move($publicPath, $originalFileName);
                auth()->user()->image = $originalFileName;
                auth()->user()->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Profile image successfully uploaded',
                    'imageUrl' => asset('assets/images/admins/' . $originalFileName),
                ]);
            }
            return response()->json(['success' => false, 'message' => 'Failed to upload the profile image.'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
