<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserPseudoRecord extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    /**
     * @var mixed|string
     */
    protected $table = 'user_pseudo_records';
    protected $primaryKey = 'id';
    public static array $logEvents = ['created', 'updated', 'deleted'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'morph_type',
        'morph_id',
        'pseudo_name',
        'pseudo_email',
        'pseudo_phone',
        'server_host',
        'server_port',
        'server_encryption',
        'server_username',
        'server_password',
        'imap_type',
        'creator_type',
        'creator_id',
        'is_verified',
        'status',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'integer',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
    ];

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
     * Get the related user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
