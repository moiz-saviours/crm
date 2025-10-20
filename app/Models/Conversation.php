<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'conversation_status',
        'last_message_id',
        'status'
    ];

    public function sender()
    {
        return $this->morphTo();
    }
    public function receiver()
    {
        return $this->morphTo();
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }
}
