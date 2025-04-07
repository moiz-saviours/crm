<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Department extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'departments';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'status'];

    /**
     * Get the roles associated with the department.
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'department_id');
    }
}
