<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Position extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'positions';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['role_id', 'name',  'status'];

    /**
     * Get the role that owns the position.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
