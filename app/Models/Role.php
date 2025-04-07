<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'roles';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['department_id', 'name', 'status'];

    /**
     * Get the department that owns the role.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the positions associated with the role.
     */
    public function positions()
    {
        return $this->hasMany(Position::class, 'role_id');
    }
}
