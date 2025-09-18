<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerNote extends Model
{
    use SoftDeletes, ActivityLoggable;

    protected $table = 'customer_notes';
    protected $fillable = [
        'cus_contact_key',
        'note',
    ];

    public function customer_contact()
    {
        return $this->belongsTo(CustomerContact::class, 'cus_contact_key', 'special_key');
    }

    public function creator()
    {
        return $this->morphTo('creator');
    }
}
