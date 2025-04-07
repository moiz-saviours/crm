<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PaymentMerchant extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'payment_merchants';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand_key',
        'c_contact_key',
        'c_company_key',
        'name',
        'descriptor',
        'vendor_name',
        'email',
        'payment_method',
        'login_id',
        'transaction_key',
        'test_login_id',
        'test_transaction_key',
        'limit',
        'capacity',
        'environment',
        'status',
    ];

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_key', 'brand_key');
    }

    public function client_contact(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClientContact::class, 'c_contact_key', 'special_key');
    }

    public function client_company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClientCompany::class, 'c_company_key', 'special_key');
    }

    public function brands(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(
            Brand::class,          // Related model
            'assignable',          // Morph name
            AssignBrandAccount::class,
            'assignable_id',       // Foreign key on pivot table
            'brand_key',            // Related model key on pivot table
            'id',                  // Local model key
            'brand_key'                   // Related model key
        );
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class, 'merchant_id');
    }

    /**Scopes*/
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeHasSufficientLimitAndCapacity($query, $merchantId, $amount)
    {
        $total_amount = Payment::where('merchant_id', $merchantId)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('amount');
        $total_amount += $amount;
        return $query->where('id', $merchantId)
            ->where('limit', '>=', (float)$amount)
            ->where('capacity', '>=', (float)$total_amount);
    }

    /**
     * Adds monthly usage data to the query results by summing payment amounts
     * for the current month and grouping by merchant ID.
     *
     */
    public function scopeWithMonthlyUsage($query)
    {
        return $query->with(['payments' => function ($query) {
            $query->selectRaw('merchant_id, SUM(amount) as total_amount')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->groupBy('merchant_id');
        }]);
    }
    /**Scopes*/
    /** Attributes */
    /**
     * Get the formatted monthly usage amount for the current month.
     *
     * This accessor calculates the sum of all payment amounts associated with this merchant
     * for the current month and year, then formats it with thousand separators.
     *
     * Returns '0' if no payments exist.
     *
     * @return string Formatted amount with thousand separators
     *
     * @example
     * <code>
     * $merchant->current_month_usage; // "1,250.00"
     * </code>
     */
    public function getCurrentMonthUsageAttribute(): string
    {
        $totalAmount = $this->payments()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount') ?? 0;
        return number_format($totalAmount);
    }
    /** Attributes */
}
