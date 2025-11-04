<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cus_company_key',
        'cus_contact_key',
        'deal_owner_id',
        'deal_owner_type',
        'name',
        'deal_stage',
        'amount',
        'start_date',
        'close_date',
        'deal_type',
        'priority',
        'services',
        'is_contact_start_date',
        'contact_start_date',
        'is_company_start_date',
        'company_start_date',
        'creator_id',
        'creator_type',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'close_date' => 'date',
        'contact_start_date' => 'date',
        'company_start_date' => 'date',
        'is_contact_start_date' => 'boolean',
        'is_company_start_date' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Relationship with CustomerCompany
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CustomerCompany::class, 'cus_company_key', 'special_key');
    }

    /**
     * Relationship with CustomerContact
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(CustomerContact::class, 'cus_contact_key', 'special_key');
    }

    /**
     * Relationship with Deal Owner (polymorphic)
     */
    public function dealOwner(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relationship with Creator (polymorphic)
     */
    public function creator(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Accessor for deal stage name
     */
    public function getDealStageNameAttribute(): string
    {
        $stages = [
            1 => 'Appointment Scheduled',
            2 => 'Qualified To Buy',
            3 => 'Presentation Scheduled',
            4 => 'Decision Maker Bought-In',
            5 => 'Contract Sent',
            6 => 'Closed Won',
            7 => 'Closed Lost'
        ];

        return $stages[$this->deal_stage] ?? 'Unknown';
    }

    public function getServiceNameAttribute(): string
    {
        $services = [
            1 => 'App Development',
            2 => 'Animation Services',
            3 => 'Marketing Services', 
            4 => 'Content Writing',
            5 => 'Website Design',
            6 => 'Logo Design'
        ];

        return $services[$this->services] ?? 'Unknown';
    }
}