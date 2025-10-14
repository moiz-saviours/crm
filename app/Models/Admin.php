<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'admins';
    protected $guard = 'admin';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'pseudo_name', 'email', 'pseudo_email', 'password', 'type', 'designation', 'gender', 'image', 'phone_number', 'pseudo_phone', 'address', 'city', 'country', 'postal_code', 'age', 'dob', 'about', 'status', 'settings',];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
        ];
    }

    /**
     * Accessor to calculate age based on date of birth.
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        return $this->dob ? Carbon::parse($this->dob)->age : null;
    }

    /**
     * Mutator to update the age attribute when dob is set.
     *
     * @param string|\DateTimeInterface|null $value
     * @return void
     */
    public function setDobAttribute($value)
    {
        $date = $value ? Carbon::parse($value) : null;
        $this->attributes['dob'] = $date;
        $this->attributes['age'] = $date ? $date->age : null;
    }
    public function pseudo_records()
    {
        return $this->morphMany(UserPseudoRecord::class, 'morph');
    }
}
