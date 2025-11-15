<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ActivityLoggable;
use App\Traits\ForceLogoutTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use  HasApiTokens, HasFactory, Notifiable, SoftDeletes, ActivityLoggable, ForceLogoutTrait;

    protected $primaryKey = 'id';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'role_id',
        'position_id',
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
        'settings',
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
            'settings' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::updated(function ($user) {
            if ($user->shouldForceLogout()) {
                $this->forceLogoutUser($user);
            }
        });
    }

    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Team::class, AssignTeamMember::class, 'user_id', 'team_key', 'id', 'team_key')->withTimestamps();
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'agent');
    }

    public function pseudo_records()
    {
        return $this->morphMany(UserPseudoRecord::class, 'morph');
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function verification_codes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(VerificationCode::class, 'morph')->withTrashed();
    }

    /**
     * Get the user's preferred locale.
     */
    public function preferredLocale(): string
    {
        return $this->locale;
    }

    public function scopeDepartment($query, $department)
    {
        return $query->whereHas('department', fn($q) => $q->where('name', $department));
    }

    public function shouldForceLogout(): bool
    {
        return $this->wasChanged([
            'password',
            'email',
            'email_verified_at',
            'status',
            'deleted_at',
        ]);
    }
}
