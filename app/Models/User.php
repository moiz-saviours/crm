<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ActivityLoggable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use  HasApiTokens, HasFactory, Notifiable, SoftDeletes, ActivityLoggable;

    protected $primaryKey = 'id';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'emp_id',
        'name',
        'pseudo_name',
        'email',
        'pseudo_email',
        'password',
        'team_key',
        'designation',
        'gender',
        'phone_number',
        'pseudo_phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'dob',
        'date_of_joining',
        'about',
        'status',
        'target',
        'image',
        'last_seen',
        'last_ip_address',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Team::class, AssignTeamMember::class, 'user_id', 'team_key', 'id', 'team_key')->withTimestamps();
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'agent');
    }
}
