<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ClientContact extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'client_contacts';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'special_key',
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
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($client_contact) {
            $client_contact->special_key = self::generateSpecialKey();
            if (auth()->check()) {
                $client_contact->creator_type = get_class(auth()->user());
                $client_contact->creator_id = auth()->user()->id;
            }
        });
    }

    public function brands(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(
            Brand::class,          // Related model
            'assignable',          // Morph name
            AssignBrandAccount::class,
            'assignable_id',       // Foreign key on pivot table
            'brand_key',            // Related model key on pivot table
            'special_key',                  // Local model key
            'brand_key'                   // Related model key
        );
    }

    public function companies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientCompany::class, 'c_contact_key', 'special_key');
    }

    public function client_companies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientCompany::class, 'c_contact_key', 'special_key')->where('status', 1);
    }

    public function client_accounts(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            PaymentMerchant::class,  // The related model (distant model)
            ClientCompany::class,    // The intermediary model (middle model)
            'special_key',           // Foreign key on the intermediate model (ClientCompany) referencing the parent model (ClientContact)
            'c_contact_key',                     // Local key on the intermediate model (ClientCompany)
            'special_key',                    // Local key on the parent model (ClientContact)
            'c_company_key'         // Foreign key on the distant model (PaymentMerchant) referencing the intermediate model (ClientCompany)
        )->where('payment_merchants.status', 'active');
    }

    /** Scope */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /** Scope */
}
