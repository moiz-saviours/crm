<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
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
}
