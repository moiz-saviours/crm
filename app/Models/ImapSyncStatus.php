<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ImapSyncStatus extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'imap_sync_statuses';
    protected $guarded = [];
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo_record_id',
        'folder_name',
        'last_uid',
        'uid_validity',
        'last_sync_at',
        'synced_count',
        'sync_error',
    ];
    protected $casts = [
        'last_uid' => 'integer',
        'uid_validity' => 'integer',
        'synced_count' => 'integer',
        'last_sync_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function pseudoRecord()
    {
        return $this->belongsTo(UserPseudoRecord::class, 'pseudo_record_id', 'id');
    }
}
