<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class VerificationCode extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    /**
     * @var mixed|string
     */
    protected $table = 'verification_codes';
    protected $primaryKey = 'id';
    public static array $logEvents = ['created', 'updated'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'morph_id',
        'morph_type',
        'code',
        'method',
        'expires_at',
        'verified_at',
        'response',
        'response_id',
        'status',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function morph(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('morph');
    }

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
            ->whereNull('verified_at');
    }

    public function markAsVerified(): void
    {
        $this->update(['verified_at' => now()]);
    }
}
