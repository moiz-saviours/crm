<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id', 'special_key', 'customer_special_key', 'brand_key', 'team_key',
        'type', 'value', 'label', 'theme_color', 'project_status', 'is_progress',
        'progress', 'bill_type', 'total_rate', 'estimated_hours', 'start_date',
        'deadline', 'tags', 'description', 'is_notify', 'creator_type', 'creator_id', 'status'
    ];

    protected $casts = [
        'tags' => 'array',
        'start_date' => 'date',
        'deadline' => 'date',
        'total_rate' => 'decimal:2',
        'estimated_hours' => 'decimal:2',
    ];

    // Relationships
    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class);
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Helper methods for views
    public function getStatusColor()
    {
        return match($this->project_status) {
            'isprogress' => 'primary',
            'on hold' => 'warning',
            'cancelled' => 'danger',
            'finished' => 'success',
            default => 'secondary'
        };
    }

    public function getValueColor()
    {
        return match($this->value) {
            'regular' => 'secondary',
            'standard' => 'primary',
            'premium' => 'success',
            'exclusive' => 'warning',
            default => 'secondary'
        };
    }

    public function getProgressColor()
    {
        if ($this->progress >= 80) return 'success';
        if ($this->progress >= 50) return 'primary';
        if ($this->progress >= 20) return 'warning';
        return 'danger';
    }

    public function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Accessor for dates
    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->deadline, false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->deadline < now();
    }
}
