<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if ($request->hasFile('image')) {
            $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/images/employees'), $originalFileName);
            $user->image = $originalFileName;
        }
        $user->save();
        return Redirect::route('user.profile')->with('status', 'Profile updated successfully!');
    }

    /**
     * Handle profile image update via AJAX
     */
    public function image_update(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $user = $request->user();
                $originalFileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('assets/images/employees'), $originalFileName);
                $user->image = $originalFileName;
                $user->save();
                return response()->json([
                    'message' => 'Profile image updated successfully.',
                    'image_url' => asset('storage/assets/images/employees/' . $originalFileName)
                ]);
            }
        }
        catch (\Exception $e) {
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
