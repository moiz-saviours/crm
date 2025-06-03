<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.channels.index', [
            'channels' => Channel::with('creator', 'owner')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.channels.create', [
            'timezones' => \DateTimeZone::listIdentifiers(),
            'languages' => config('app.available_locales')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChannelRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['last_activity_at'] = now();
            $channel = Channel::create($data);
            $this->handleFileUploads($request, $channel);
            DB::commit();
            return $this->smartResponse($request, $channel, 'admin.channels.index', 'Channel created successfully.', 'channel');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->smartError($request, $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Channel $channel)
    {
        $channel->updateLastActivity();
        if ($request->ajax() || $request->wantsJson()) {
            return $this->smartResponse(
                $request,
                $channel->load(['creator', 'owner']),
                null,
                'Channel details fetched successfully.',
                'channel'
            );
        }
        return view('admin.channels.show', compact('channel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Channel $channel)
    {
        try {
            $channel->updateLastActivity();
            if ($request->ajax() || $request->wantsJson()) {
                return $this->smartResponse($request, $channel, null, 'Channel fetched successfully.', 'channel');
            }
            return view('admin.channels.edit', [
                'channel' => $channel,
                'timezones' => \DateTimeZone::listIdentifiers(),
                'languages' => config('app.available_locales')
            ]);
        } catch (\Exception $e) {
            return $this->smartError($request, $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        try {
            DB::beginTransaction();
            $channel->update(array_merge(
                $request->validated(),
                ['last_activity_at' => now()]
            ));
            $this->handleFileUploads($request, $channel);
            DB::commit();
            return $this->smartResponse(
                $request,
                $channel,
                'admin.channels.index',
                'Channel updated successfully.',
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->smartError($request, $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        try {
            DB::beginTransaction();
//            $this->deleteChannelFiles($channel);
            $channel->delete();
            DB::commit();
            return $this->smartResponse(
                request(),
                null,
                'admin.channels.index',
                'Channel deleted successfully.',
                'channel'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->smartError(request(), $e);
        }
    }

    /**
     * Handle file uploads for channel
     */
    protected function handleFileUploads(Request $request, Channel $channel)
    {
        $logoPath = 'assets/images/channel-logos';
        $faviconPath = 'assets/images/channel-favicons';
        if (!file_exists(public_path($logoPath))) {
            mkdir(public_path($logoPath), 0755, true);
        }
        if (!file_exists(public_path($faviconPath))) {
            mkdir(public_path($faviconPath), 0755, true);
        }
        if ($request->hasFile('logo')) {
//            if ($channel->logo && file_exists(public_path($channel->logo))) {
//                unlink(public_path($channel->logo));
//            }
            $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('assets/images/channel-logos'), $originalFileName);
            $channel->update(['logo' => $originalFileName]);
        }
        if ($request->hasFile('favicon')) {
//            if ($channel->favicon && file_exists(public_path($channel->favicon))) {
//                unlink(public_path($channel->favicon));
//            }
            $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('favicon')->move(public_path('assets/images/channel-favicons'), $originalFileName);
            $channel->update(['favicon' => $originalFileName]);
        }
    }

    /**
     * Delete channel files
     */
    protected function deleteChannelFiles(Channel $channel)
    {
        if ($channel->logo && file_exists(public_path($channel->logo))) {
            unlink(public_path($channel->logo));
        }
        if ($channel->favicon && file_exists(public_path($channel->favicon))) {
            unlink(public_path($channel->favicon));
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, Channel $channel)
    {
        try {
            if (!$channel->id) {
                return response()->json(['error' => 'Record not found. Please try again later.'], 404);
            }
            $channel->status = $request->query('status');
            $channel->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
