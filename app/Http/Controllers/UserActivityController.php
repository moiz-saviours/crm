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
        $activities = UserActivity::where('event_type','page_view')->latest()->get()->map(function ($activity) {
            $data = json_decode($activity->event_data, true);

            $ip       = $activity->ip;
            $browser  = $activity->browser;
            $visitor  = $activity->visitor_id ?? 'Unknown Visitor';
            $location = trim(($activity->city ? $activity->city . ', ' : '') . ($activity->country ?? ''), ', ');

            $details = $this->makeReadable($data);
            return [
                'id' => $activity->id,
                'ip' => $ip,
                'browser' => $browser,
                'visitor' => $visitor,
                'location' => $location,
                'details' => $details,
                ...$data,
                'created_at' =>  Carbon::parse($activity->created_at)->addHours(5)->format('Y-m-d h:i:s A'),
                'user_in_time'=>Carbon::parse($data['user_in_time'])->addHours(5)->format('Y-m-d h:i:s A'),
                'user_out_time'=>Carbon::parse($data['user_out_time'])->addHours(5)->format('Y-m-d h:i:s A'),
                'user_agent'=>$activity->user_agent,
                'message'=>"Visitor {$visitor} with IP {$ip} using {$browser}"
                    . ($location ? " from {$location}" : "")
                    . " {$details}"
            ];
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




//    public function store(Request $request)
//    {
//        try {
//            $userIp = $request->input('public_ip') ?? $request->ip();
//            $response = Http::timeout(5)->get("http://ip-api.com/json/{$userIp}");
//            if ($response->ok()) {
//                $geo = $response->json();
//            }
//        } catch (\Exception $e) {
//            $geo = [];
//        }
//
//
//        $browser = $this->getBrowser($request->userAgent());
//
//        $eventData = $request->event_data;
//        $eventData = array_merge($eventData, [
//            'ip'       => $geo['query'] ?? null,
//            'browser'  => $browser,
//            'country'  => $geo['country'] ?? null,
//            'state'    => $geo['regionName'] ?? null,
//            'region'   => $geo['region'] ?? null,
//            'city'     => $geo['city'] ?? null,
//            'zip_code' => $geo['zip'] ?? null,
//            'latitude' => $geo['lat'] ?? null,
//            'longitude'=> $geo['lon'] ?? null,
//        ]);
//
//        UserActivity::create([
//            'visitor_id' => $request->visitor_id,
//            'event_type' => $request->event_type,
//            'event_data' => json_encode($eventData),
//            'ip'         => $geo['query'] ?? null,
//            'user_agent' => $request->userAgent(),
//            'browser'    => $browser,
//            'country'    => $geo['country'] ?? null,
//            'state'      => $geo['regionName'] ?? null,
//            'region'     => $geo['region'] ?? null,
//            'city'       => $geo['city'] ?? null,
//            'zip_code'   => $geo['zip'] ?? null,
//            'latitude'   => $geo['lat'] ?? null,
//            'longitude'  => $geo['lon'] ?? null,
//        ]);
//
//        return response()->json(['status' => 'ok']);
//    }

    public function store(Request $request)
    {
        $deviceInfo = [];

        try {
            // Step 1: Detect public IP (handles localhost)
            $userIp = $request->input('public_ip')
                ?? $request->server('HTTP_X_FORWARDED_FOR')
                ?? $request->server('REMOTE_ADDR')
                ?? $request->ip();

            if (in_array($userIp, ['127.0.0.1', '::1'])) {
                try {
                    $ipResponse = Http::timeout(5)->get('https://api64.ipify.org?format=json');
                    if ($ipResponse->successful()) {
                        $userIp = $ipResponse->json()['ip'];
                    }
                } catch (\Exception $e) {
                    \Log::warning('Unable to fetch public IP on localhost', ['error' => $e->getMessage()]);
                }
            }

            // Step 2: Get location info from ip-api.com
            $ipapiRes = Http::timeout(5)->get("http://ip-api.com/json/{$userIp}");
            if ($ipapiRes->successful()) {
                $geo = $ipapiRes->json();
                $deviceInfo = [
                    'ip'       => $geo['query'] ?? null,
                    'city'     => $geo['city'] ?? null,
                    'state'    => $geo['regionName'] ?? null,
                    'zipcode'  => $geo['zip'] ?? null,
                    'country'  => $geo['country'] ?? null,
                    'latitude' => $geo['lat'] ?? null,
                    'longitude'=> $geo['lon'] ?? null,
                ];
            }
        } catch (\Exception $ex) {
            $deviceInfo['location_error'] = 'Unable to fetch location';
        }

        // Step 3: Merge event data + device info
        $browser = $this->getBrowser($request->userAgent());
        $eventData = array_merge((array)$request->event_data, $deviceInfo, ['browser' => $browser]);

        // Step 4: Store activity (works for any event type)
        UserActivity::create([
            'visitor_id' => $request->visitor_id,
            'event_type' => $request->event_type,
            'event_data' => json_encode($eventData),
            'ip'         => $deviceInfo['ip'] ?? null,
            'user_agent' => $request->userAgent(),
            'browser'    => $browser,
            'country'    => $deviceInfo['country'] ?? null,
            'state'      => $deviceInfo['state'] ?? null,
            'city'       => $deviceInfo['city'] ?? null,
            'zip_code'   => $deviceInfo['zipcode'] ?? null,
            'latitude'   => $deviceInfo['latitude'] ?? null,
            'longitude'  => $deviceInfo['longitude'] ?? null,
        ]);

        return response()->json(['status' => 'ok']);
    }


    private function getBrowser($userAgent)
    {
        $browsers = [
            'Edge' => 'Edg',
            'Opera' => 'OPR',
            'Vivaldi' => 'Vivaldi',
            'Brave' => 'Brave',
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Internet Explorer' => 'MSIE|Trident'
        ];
        foreach ($browsers as $browser => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                return $browser;
            }
        }
        return 'Unknown';
    }
}
