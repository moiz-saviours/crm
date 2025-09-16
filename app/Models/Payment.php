<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    const STATUS_DUE = 0;
    const STATUS_PAID = 1;
    const STATUS_REFUNDED = 2;
    const STATUS_CHARGEBACK = 3;
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
        'agent_type',
        'merchant_id',
        'merchant_name',
        'transaction_id',
        'response',
        'transaction_response',
        'currency',
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
        'payment_date' => 'datetime',
    ];
    protected $hidden = [
        'card_name',
        'card_type',
        'card_number',
        'card_cvv',
        'card_month_expiry',
        'card_year_expiry',];

    protected $appends = ['payment_date_formatted', 'created_at_formatted'];

    public function getPaymentDateFormattedAttribute()
    {
        return $this->payment_date
            ? $this->formatForDisplay($this->payment_date)
            : null;
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at
            ? $this->formatForDisplay($this->created_at, 'GMT+5',true)
            : null;
    }
    function formatForDisplay($date, string $timezone = 'GMT+5',$isTimezone = false): ?string
    {
        if (!$date) {
            return null;
        }
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);
        if ($isTimezone){
            $date = $date->copy()->timezone($timezone);
        }else{
            $date = $date->copy();
        }
        if ($date->isToday()) {
            return 'Today at ' . $date->format('g:i A') . ' ' . $timezone;
        }
        return $date->format('M d, Y g:i A') . ' ' . $timezone;
    }

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
