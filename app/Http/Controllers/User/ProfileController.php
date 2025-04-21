<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        return view('user.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $messages = [
            'pseudo_name.string' => 'The first name must be a string.',
            'pseudo_name.max' => 'The first name must not exceed 255 characters.',
            'pseudo_email.email' => 'The email must be a valid email address.',
            'pseudo_email.max' => 'The email must not exceed 255 characters.',
            'pseudo_email.unique' => 'The email has already been taken.',
            'pseudo_phone.string' => 'The phone number must be a string.',
            'pseudo_phone.max' => 'The phone number must not exceed 20 characters.',
        ];
        $validatedData = $request->validate([
            'pseudo_name' => 'nullable|string|max:255',
            'pseudo_email' => 'nullable|email|max:255|unique:users,pseudo_email,' . $user->id,
            'pseudo_phone' => 'nullable|string|max:20',
        ], $messages);
        try {

            $user->pseudo_name = $validatedData['pseudo_name'] ?? $user->pseudo_name;
//            if ($user->isDirty('email')) {
//                $user->email_verified_at = null;
//            }
            $user->pseudo_email = $validatedData['pseudo_email'] ?? $user->pseudo_email;
            $user->pseudo_phone = $validatedData['pseudo_phone'] ?? $user->pseudo_phone;
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
     * Handle profile image update via AJAX
     */
    public function image_update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);
        try {
            if ($request->hasFile('image')) {
                $user = $request->user();
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('assets/images/employees'), $originalFileName);
                $user->image = $originalFileName;
                $user->save();
                return response()->json([
                    'message' => 'Profile image updated successfully.',
                    'image_url' => asset('assets/images/employees/' . $originalFileName)
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
