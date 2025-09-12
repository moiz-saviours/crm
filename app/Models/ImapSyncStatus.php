<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImapSyncStatus extends Model
{
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

    public function pseudoRecord()
    {
        return $this->belongsTo(UserPseudoRecord::class, 'pseudo_record_id');
    }
}