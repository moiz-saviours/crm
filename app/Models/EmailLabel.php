<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLabel extends Model
{
    protected $fillable = [
        'pseudo_record_id',
        'name',
        'color',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function pseudoRecord()
    {
        return $this->belongsTo(UserPseudoRecord::class, 'pseudo_record_id');
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'email_label_pivot', 'label_id', 'email_id')
            ->withTimestamps();
    }
}