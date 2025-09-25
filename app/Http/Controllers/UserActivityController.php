<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserActivityController extends Controller
{

    public function index()
    {
        $activities = UserActivity::latest()->get()->map(function ($activity) {
            $data = json_decode($activity->event_data, true);

            $ip       = $activity->ip;
            $browser  = $activity->browser;
            $location = trim(($activity->city ? $activity->city . ', ' : '') . ($activity->country ?? ''), ', ');

            $details = $this->makeReadable($data);

            return "User with IP {$ip} using {$browser}"
                . ($location ? " from {$location}" : "")
                . " {$details}";
        });

        return view('admin.user-activity.index', compact('activities'));
    }

    private function makeReadable($data)
    {
        $parts = [];

        if (isset($data['user_in_time'])) {
            $parts[] = "entered at " . Carbon::parse($data['user_in_time'])->format('Y-m-d H:i:s');
        }

        if (isset($data['user_out_time'])) {
            $parts[] = "left at " . Carbon::parse($data['user_out_time'])->format('Y-m-d H:i:s');
        }

        if (isset($data['url'])) {
            $parts[] = "visited '{$data['url']}'";
        }

        if (isset($data['total_duration'])) {
            $parts[] = "stayed for {$data['total_duration']} seconds";
        }

        if (isset($data['scroll_max_percent'])) {
            $parts[] = "scrolled {$data['scroll_max_percent']}% down";
        }

        if (!empty($data['click_count'])) {
            $parts[] = "clicked {$data['click_count']} times";
        }

        if (!empty($data['form_submissions'])) {
            foreach ($data['form_submissions'] as $form) {
                $parts[] = "submitted form '{$form['form_name']}'";
            }
        }

        return $parts ? 'and ' . implode(', ', $parts) : '';
    }




    public function store(Request $request)
    {
        try {
            $response = Http::timeout(5)->get("http://ip-api.com/json/");
            if ($response->ok()) {
                $geo = $response->json();
            }
        } catch (\Exception $e) {
            $geo = [];
        }


        $browser = $this->getBrowser($request->userAgent());

        UserActivity::create([
            'event_type' => $request->event_type,
            'event_data' => json_encode($request->event_data),
            'ip'         => $geo['query'] ?? null,
            'user_agent' => $request->userAgent(),
            'browser'    => $browser,
            'country'    => $geo['country'] ?? null,
            'state'      => $geo['regionName'] ?? null,
            'region'     => $geo['region'] ?? null,
            'city'       => $geo['city'] ?? null,
            'zip_code'   => $geo['zip'] ?? null,
            'latitude'   => $geo['lat'] ?? null,
            'longitude'  => $geo['lon'] ?? null,
        ]);

        return response()->json(['status' => 'ok']);
    }


    private function getBrowser($userAgent)
    {
        if (preg_match('/MSIE|Trident/', $userAgent)) return "Internet Explorer";
        elseif (preg_match('/Edge/', $userAgent)) return "Edge";
        elseif (preg_match('/OPR|Opera/', $userAgent)) return "Opera";
        elseif (preg_match('/Chrome/', $userAgent)) return "Chrome";
        elseif (preg_match('/Safari/', $userAgent)) return "Safari";
        elseif (preg_match('/Firefox/', $userAgent)) return "Firefox";
        else return "Unknown";
    }
}
