<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'brand_id',
        'special_key',
        'brand_key',
        'team_key',
        'type',
        'value',
        'label',
        'theme_color',
        'status',
        'bill_type',
        'is_progress',
        'total_rate',
        'estimated_hours',
        'start_date',
        'deadline',
        'tags',
        'description',
        'is_notify',
        'progress',
        'created_morph_id',
        'created_morph_type'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_progress' => 'boolean',
        'is_notify' => 'boolean',
        'start_date' => 'date',
        'deadline' => 'date',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function createdMorph()
    {
        return $this->morphTo();
    }
    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }
}
