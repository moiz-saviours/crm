<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'projects';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'special_key', 'cus_contact_key', 'brand_key', 'team_key',
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
        static::creating(function ($project) {
            $project->special_key = self::generateSpecialKey();
            if (auth()->check()) {
                $project->creator_type = get_class(auth()->user());
                $project->creator_id = auth()->user()->id;
            }
        });
    }

    // Relationships
    public function attachments(): Project|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectAttachment::class, 'project_id', 'id');
    }

    public function members(): Project|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectMember::class, 'project_id', 'id');
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_key', 'brand_key');
    }

    // Helper methods for views
    public function getStatusColor(): string
    {
        return match ($this->project_status) {
            'is_progress' => 'primary',
            'on hold' => 'warning',
            'cancelled' => 'danger',
            'finished' => 'success',
            default => 'secondary'
        };
    }

    public function getValueColor(): string
    {
        return match ($this->value) {
            'regular' => 'secondary',
            'standard' => 'primary',
            'premium' => 'success',
            'exclusive' => 'warning',
            default => 'secondary'
        };
    }

    public function getProgressColor(): string
    {
        if ($this->progress >= 80) return 'success';
        if ($this->progress >= 50) return 'primary';
        if ($this->progress >= 20) return 'warning';
        return 'danger';
    }

    public function formatFileSize($bytes): string
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
    public function getDaysRemainingAttribute(): float
    {
        return now()->diffInDays($this->deadline, false);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->deadline < now();
    }
}
