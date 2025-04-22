<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_key',
        'brand_key',
        'team_key',
        'cus_contact_key',
        'cc_info_key',
        'agent_id',
        'merchant_id',
        'merchant_name',
        'transaction_id',
        'response',
        'transaction_response',
        'amount',
        'payment_type',
        'payment_method',
        'payment_date',
        'card_name',
        'card_type',
        'card_number',
        'card_cvv',
        'card_month_expiry',
        'card_year_expiry',
        'status',
        'payment_environment',
    ];

    protected $casts = [
        'payment_date' => 'date:Y-m-d',
    ];
    protected $hidden = [
        'card_name',
        'card_type',
        'card_number',
        'card_cvv',
        'card_month_expiry',
        'card_year_expiry',];

    public function invoice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_key', 'invoice_key');
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_key', 'brand_key');
    }

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_key', 'team_key');
    }

    public function customer_contact(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CustomerContact::class, 'cus_contact_key', 'special_key');
    }

    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function payment_gateway(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PaymentMerchant::class, 'merchant_id', 'id');
    }
}
