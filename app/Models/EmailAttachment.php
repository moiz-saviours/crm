<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EmailAttachment extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'email_attachments';
    protected $guarded = [];
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email_id',
        'original_name',
        'mime_type',
        'size',
        'content_id',
        'is_inline',
        'base64_content',
        'storage_name',
        'storage_path',
        'extension',
    ];
    /**
     * Relationships
     */
    protected $casts = [
        'is_inline' => 'boolean',
        'size' => 'integer',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class, 'email_id', 'id');
    }
}
