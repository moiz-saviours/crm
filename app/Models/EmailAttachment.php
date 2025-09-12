<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    protected $fillable = [
        'email_id',
        'original_name',
        'storage_name',
        'mime_type',
        'size',
        'storage_path',
        'content_id',
        'is_inline',
    ];

    protected $casts = [
        'is_inline' => 'boolean',
        'size' => 'integer',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class, 'email_id');
    }
}