<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function saveSettings(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'settings' => 'required|array',
        ]);
        $settings = $this->normalizeSettings($request->settings);
        $user->settings = $settings;
        $user->save();
        return response()->json(['message' => 'Settings saved successfully!']);
    }

    protected function normalizeSettings($settings)
    {
        array_walk_recursive($settings, function (&$value) {
            if ($value === 'true') $value = true;
            if ($value === 'false') $value = false;
            if (is_numeric($value)) $value = (float)$value;
        });
        return $settings;
    }
}
