<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Email extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'emails';
    protected $guarded = [];
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo_record_id',
        'thread_id',
        'message_id',
        'in_reply_to',
        'references',
        'from_email',
        'from_name',
        'to',
        'cc',
        'bcc',
        'subject',
        'body_html',
        'body_text',
        'imap_uid',
        'imap_folder',
        'imap_flags',
        'type',
        'folder',
        'is_read',
        'is_important',
        'is_starred',
        'is_deleted',
        'message_date',
        'sent_at',
        'received_at',
    ];
    protected $casts = [
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'imap_flags' => 'array',
        'is_read' => 'boolean',
        'is_important' => 'boolean',
        'is_starred' => 'boolean',
        'is_deleted' => 'boolean',
        'message_date' => 'datetime',
        'sent_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function pseudoRecord()
    {
        return $this->belongsTo(UserPseudoRecord::class, 'pseudo_record_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class, 'email_id', 'id');
    }

    public function labels()
    {
        return $this->belongsToMany(EmailLabel::class, EmailLabelPivot::class, 'email_id', 'label_id', 'id', 'id')
            ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(EmailEvent::class);
    }
}
