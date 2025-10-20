<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'special_key', 'task_status', 'label', 'description', 'status','creator_id', 'creator_type'];

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
}
