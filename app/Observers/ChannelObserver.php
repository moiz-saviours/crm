<?php

namespace App\Observers;
use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelObserver
{
    public function creating(Channel $channel): void
    {
        if (empty($channel->slug)) {
            $channel->slug = Str::slug($channel->name);
        }
    }

    public function updating(Channel $channel): void
    {
        if ($channel->isDirty('name') && empty($channel->slug)) {
            $channel->slug = Str::slug($channel->name);
        }
    }

    public function deleted(Channel $channel)
    {
        // TODO Clean up related files or data
    }
}
