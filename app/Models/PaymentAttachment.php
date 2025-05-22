<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PaymentAttachment extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'payment_attachments';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_key',
        'email',
        'payment_method',
        'transaction_reference',
        'payment_date',
        'amount',
        'attachments',
        'status',
        'rejection_reason',
        'notes',
        'reviewed_by',
        'reviewed_at',
        'ip_address',
    ];
}
