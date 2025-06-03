<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Channel extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    /**
     * @var mixed|string
     */
    protected $table = 'channels';
    protected $primaryKey = 'id';
    public static array $logEvents = ['created', 'updated', 'deleted'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'special_key',
        'name',
        'slug',
        'url',
        'logo',
        'favicon',
        'description',
        'language',
        'timezone',
        'creator_type',
        'creator_id',
        'owner_type',
        'owner_id',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'last_activity_at'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_activity_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'logo_url',
        'favicon_url',
    ];

    /**
     * Get the URL to the channel's logo.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->logo ? asset('assets/images/channel-logos/' . $this->logo) : null,
        );
    }

    /**
     * Get the URL to the channel's favicon.
     */
    protected function faviconUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->favicon ? asset('assets/images/channel-logos/' . $this->favicon) : null,
        );
    }

    /**
     * Check if channel is active.
     */
    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status === 1,
        );
    }

    /**
     * Get the creator of the channel.
     */
    public function creator()
    {
        return $this->morphTo('creator');
    }

    /**
     * Get the owner of the channel.
     */
    public function owner()
    {
        return $this->morphTo('owner');
    }

    /**
     * Scope a query to only include active channels.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to order by most recently active.
     */
    public function scopeRecentlyActive($query)
    {
        return $query->orderBy('last_activity_at', 'desc');
    }

    /**
     * Update the last activity timestamp.
     */
    public function updateLastActivity()
    {
        $this->update(['last_activity_at' => now()]);
    }
}
