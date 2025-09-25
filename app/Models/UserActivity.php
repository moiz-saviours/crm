<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivity extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'event_type', 'event_data', 'ip', 'user_agent','country',
        'state',
        'region',
        'zip_code',
        'browser',
        'latitude',
        'longitude',
    ];
}
