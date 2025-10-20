<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'reply_to',
        'content',
        'message_type',
        'message_status',
        'is_edited',
        'edited_at',
        'status'
    ];

    protected $casts = [
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function senderable()
    {
        return $this->morphTo();
    }
    public function replyMessage()
    {
        return $this->belongsTo(Message::class, 'reply_to');
    }
    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class);
    }
}
