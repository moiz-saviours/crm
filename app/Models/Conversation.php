<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'senderable_id',
        'senderable_type',
        'receiverable_id',
        'receiverable_type',
        'conversation_status',
        'last_message_id',
        'status'
    ];

    public function senderable()
    {
        return $this->morphTo();
    }
    public function receiverable()
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
