<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use App\Traits\ActivityLoggable;
use Illuminate\Support\Str;

class Brand extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'brands';
    protected $primaryKey = 'id';
    public static array $logEvents = ['created', 'updated'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['brand_key', 'name', 'url', 'logo', 'email', 'description', 'status'];
//    public function generateBrandKey($id)
//    {
//        $idStr = (string)$id;
//        $digitsToAdd = 6 - strlen($idStr);
//        $randomDigits = '';
//        for ($i = 0; $i < $digitsToAdd; $i++) {
//            $randomDigits .= rand(0, 9);
//        }
//        $brandKey = $idStr . $randomDigits;
//        $brandKeyArray = str_split($brandKey);
//        shuffle($brandKeyArray);
//        $shuffledBrandKey = implode('', $brandKeyArray);
//        return str_pad($shuffledBrandKey, 6, '0', STR_PAD_LEFT);
//    }
    /**
     * Generate a unique special key.
     *
     * @return string
     */
    public static function generateSpecialKey(): string
    {
        do {
            $specialKey = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('brand_key', $specialKey)->exists());
        return $specialKey;
    }

    /**
     * Automatically set the special_key and creator details before creating the record.
     * @return void
     */
//    protected static function booted(): void
//    {
//        static::creating(function ($brand) {
//            $brand->brand_key = self::generateSpecialKey();
//        });
//    }
    protected static function boot()
    {
        parent::boot();
        /**
         * Automatically set the special_key and creator details before creating the record.
         * @return void
         */
        static::creating(function ($brand) {
            $brand->brand_key = self::generateSpecialKey();
        });
        static::created(function () {
            Cache::forget('brands_list');
        });
        static::updated(function () {
            Cache::forget('brands_list');
        });
        static::deleted(function () {
            Cache::forget('brands_list');
        });
        static::deleted(function () {
            Cache::forget('brands_list');
        });
    }

    /**  Customer Contact  */
    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CustomerContact::class, 'brand_key');
    }

    /** Client Relations */
    /** Define polymorphic relation for AssignBrandAccount */
//    public function brand_assignable_accounts(): \Illuminate\Database\Eloquent\Relations\MorphMany
//    {
//        return $this->morphMany(AssignBrandAccount::class, 'assignable');
//    }
//    public function brandAssignments()
//    {
//        return $this->hasMany(AssignBrandAccount::class, 'brand_key', 'brand_key');
//    }
    /** Define inverse relationship for ClientContact */
    public function client_contacts(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(
            ClientContact::class,          // Related model
            'assignable',                  // Morph name
            AssignBrandAccount::class,     // Pivot table
            'brand_key',                   // Foreign key on pivot table (refers to Brand)
            'assignable_id',               // Foreign key on pivot table (refers to ClientContact)
            'brand_key',                   // Local key on Brand model
            'special_key'                  // Related key on ClientContact model
        )->where('client_contacts.status', 1);
    }

    /** Define inverse relationship for ClientCompany */
    public function client_companies(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(
            ClientCompany::class,          // Related model
            'assignable',                  // Morph name
            AssignBrandAccount::class,     // Pivot table
            'brand_key',                   // Foreign key on pivot table (refers to Brand)
            'assignable_id',               // Foreign key on pivot table (refers to ClientCompany)
            'brand_key',                   // Local key on Brand model
            'special_key'                  // Related key on ClientCompany model
        )->where('client_companies.status', 1);
    }

    /** Define inverse relationship for ClientAccount */
    public function client_accounts(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(
            PaymentMerchant::class,          // Related model
            'assignable',                  // Morph name
            AssignBrandAccount::class,     // Pivot table
            'brand_key',                   // Foreign key on pivot table (refers to Brand)
            'assignable_id',               // Foreign key on pivot table (refers to PaymentMerchant)
            'brand_key',                   // Local key on Brand model
            'id'                  // Related key on PaymentMerchant model
        )->where('payment_merchants.status', 'active');
    }

    /** Scope */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /** Scope */

    // This will create a "virtual" attribute
    protected $appends = ['script_token'];

    public function getScriptTokenAttribute(): string
    {
        return self::generateScriptTokenFromName($this->name);
    }

    public static function generateScriptTokenFromName(string $name): string
    {
        $normalized = Str::lower($name);
        $normalized = preg_replace('/[^a-z0-9]/', '', $normalized);

        return substr(hash_hmac('sha256', $normalized, 'brand_token'), 0, 15);
    }

    public function assignedTeams()
    {
        return $this->hasMany(AssignTeamBrand::class, 'brand_key', 'brand_key')
            ->with('team');
    }
}

