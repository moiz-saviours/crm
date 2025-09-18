<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email_id', 'event_type', 'ip_address', 'user_agent', 'url', 'created_at'
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
