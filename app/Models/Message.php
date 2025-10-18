<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'senderable_id',
        'senderable_type',
        'reply_to',
        'content',
        'message_type',
        'status',
        'is_edited',
        'edited_at'
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
