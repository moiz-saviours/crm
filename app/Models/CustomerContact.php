<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class CustomerContact extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'customer_contacts';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'special_key',
        'brand_key',
        'team_key',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'ip_address',
        'creator_type',
        'creator_id',
        'status',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['last_activity', 'last_activity_formatted','created_at_formatted'];

    /**
     * Generate a unique special key.
     *
     * @return string
     */
    public static function generateSpecialKey(): string
    {
        do {
            $specialKey = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('special_key', $specialKey)->exists());
        return $specialKey;
    }

    /**
     * Automatically set the special_key and creator details before creating the record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($customer_contact) {
            $customer_contact->special_key = self::generateSpecialKey();
            if (auth()->check()) {
                $customer_contact->creator_type = get_class(auth()->user());
                $customer_contact->creator_id = auth()->user()->id;
            }
        });
    }

    /**
     * Get the last activity timestamp for this customer
     */
    public function getLastActivityAttribute()
    {
        if (!$this->special_key) return null;
        $times = collect([
            $this->getLastEmailActivity(),
            $this->getLastNoteActivity(),
            $this->getLastUserActivity(),
            $this->getLastInvoiceActivity(),
            $this->getLastPaymentActivity(),
            $this->getLastLeadActivity(),
            $this->updated_at,
            $this->created_at,
        ])->filter()->map(fn($t) => $t instanceof \Carbon\Carbon ? $t : \Carbon\Carbon::parse($t));
        return $times->isNotEmpty() ? $times->sortDesc()->first()->clone() : null;
    }

    /**
     * Get the formatted last activity for display
     */
    public function getLastActivityFormattedAttribute()
    {
        $lastActivity = $this->last_activity;
        if (!$lastActivity) {
            return '---';
        }
        $activityDate = Carbon::parse($lastActivity)->timezone('GMT+5');
        if ($activityDate->isToday()) {
            return "Today at {$activityDate->format('g:i A')} GMT+5";
        } else {
            return "{$activityDate->format('M d, Y g:i A')} GMT+5";
        }
    }
    /**
     * Get the formatted created at for display
     */
    public function getCreatedAtFormattedAttribute()
    {
        $created_at = $this->created_at;
        if (!$created_at) {
            return '---';
        }
        $Date = Carbon::parse($created_at)->timezone('GMT+5');
        if ($Date->isToday()) {
            return "Today at {$Date->format('g:i A')} GMT+5";
        } else {
            return "{$Date->format('M d, Y g:i A')} GMT+5";
        }
    }

    protected function getLastEmailActivity()
    {
        return Email::where(function ($q) {
            $q->where('from_email', $this->email)
                ->orWhereJsonContains('to', ['email' => $this->email])
                ->orWhereJsonContains('cc', ['email' => $this->email])
                ->orWhereJsonContains('bcc', ['email' => $this->email]);
        })->max('message_date');
    }

    protected function getLastNoteActivity()
    {
        return CustomerNote::where('cus_contact_key', $this->special_key)->max('created_at');
    }

    protected function getLastUserActivity()
    {
        return UserActivity::whereHas('lead.customer_contact', function ($q) {
            $q->where('email', $this->email);
        })->max('created_at');
    }

    protected function getLastInvoiceActivity()
    {
        return Invoice::where('cus_contact_key', $this->special_key)->max('updated_at');
    }

    protected function getLastPaymentActivity()
    {
        return Payment::where('cus_contact_key', $this->special_key)->max('updated_at');
    }

    protected function getLastLeadActivity()
    {
        return Lead::where('cus_contact_key', $this->special_key)->max('updated_at');
    }

    /**
     * The brand associated with the customer contact.
     */
    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_key', 'brand_key');
    }

    /**
     * The team associated with the customer contact.
     */
    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_key', 'team_key');
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CustomerCompany::class, 'cus_company_key', 'special_key');
    }

    public function companies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CustomerCompany::class, AssignCompanyContact::class, 'cus_contact_key', 'cus_company_key', 'special_key', 'special_key')->withTimestamps();
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->morphTo('creator');
    }

    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invoice::class, 'cus_contact_key', 'special_key');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class, 'cus_contact_key', 'special_key');
    }

    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CustomerNote::class, 'cus_contact_key', 'special_key');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class, 'cus_contact_key', 'special_key');
    }

    /** Scope */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /** Scope */
}
