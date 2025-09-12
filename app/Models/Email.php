<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;

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

    public function pseudoRecord()
    {
        return $this->belongsTo(UserPseudoRecord::class, 'pseudo_record_id');
    }

    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class, 'email_id');
    }

    public function labels()
    {
        return $this->belongsToMany(EmailLabel::class, 'email_label_pivot', 'email_id', 'label_id')
            ->withTimestamps();
    }
}