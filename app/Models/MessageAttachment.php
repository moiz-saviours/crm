<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    protected $fillable = ['message_id', 'file_name', 'file_path', 'file_type', 'file_size'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
