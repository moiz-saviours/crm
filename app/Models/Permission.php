<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Permission extends Model
{
    protected $fillable = [
        'model_type',
        'action',
        'description'
    ];
}
