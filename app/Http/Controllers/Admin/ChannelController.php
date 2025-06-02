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
        return view('admin.channels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChannelRequest $request)
    {
        try {
            DB::beginTransaction();
            $channel = Channel::create(array_merge($request->validated(), [
                'last_activity_at' => now(),
            ]));
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('assets/images/channel-logos'), $originalFileName);
                $channel->update(['logo' => $originalFileName]);
            }
            DB::commit();
            return $this->smartResponse($request, $channel, 'admin.channels.index', 'Channel created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->smartError($request, $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        $channel->update($request->validated());
        return redirect()->route('admin.channels.index')->with('success', 'Channel updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();
        return redirect()->route('admin.channels.index')->with('success', 'Channel deleted!');
    }
}
