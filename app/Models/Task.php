<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ['order_column','project_id', 'special_key', 'task_status', 'label', 'description', 'status','creator_id', 'creator_type'];

    // Relationships

    public static function generateSpecialKey(): string
    {
        do {
            $specialKey = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('special_key', $specialKey)->exists());
        return $specialKey;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }

    public function members()
    {
        return $this->hasMany(TaskMember::class);
    }

    public function creator()
    {
        return $this->morphTo();
    }

    // Helper methods
    public function getStatusColor()
    {
        return match($this->task_status) {
            'is_progress' => 'primary',
            'on_hold' => 'warning',
            'cancelled' => 'danger',
            'finished' => 'success',
            default => 'secondary'
        };
    }

    public function formatFileSize($bytes)
    {
        if ($bytes == 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 1) . ' ' . $sizes[$i];
    }
}
