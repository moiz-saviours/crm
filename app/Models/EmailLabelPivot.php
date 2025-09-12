<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Pivot;

class EmailLabelPivot extends Pivot
{
    protected $table = 'email_label_pivot';

    protected $fillable = [
        'email_id',
        'label_id',
    ];
}