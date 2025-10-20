<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    protected $fillable = [
        'task_id',
        'member_id',
        'member_type',
        'role',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function memberable()
    {
        return $this->morphTo();
    }
}
