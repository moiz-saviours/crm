<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class Team extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'teams';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['team_key', 'lead_id', 'name', 'description', 'status'];

//    public function generateTeamKey($id)
//    {
//        $idStr = (string)$id;
//        $digitsToAdd = 6 - strlen($idStr);
//        $randomDigits = '';
//        for ($i = 0; $i < $digitsToAdd; $i++) {
//            $randomDigits .= rand(0, 9);
//        }
//        $teamKey = $idStr . $randomDigits;
//        $teamKeyArray = str_split($teamKey);
//        shuffle($teamKeyArray);
//        $shuffledTeamKey = implode('', $teamKeyArray);
//        return str_pad($shuffledTeamKey, 6, '0', STR_PAD_LEFT);
//    }
    public static function generateSpecialKey(): string
    {
        do {
            $specialKey = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('team_key', $specialKey)->exists());
        return $specialKey;
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, AssignTeamMember::class, 'team_key', 'user_id', 'team_key', 'id')->withTimestamps();
    }
    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'assign_team_brands', 'team_key', 'brand_key', 'team_key', 'brand_key')
            ->withTimestamps();
    }

    public function targets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TeamTarget::class, 'team_key','team_key');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($brand) {
            $brand->team_key = self::generateSpecialKey();
        });
        static::created(function () {
            Cache::forget('teams_list');
        });
        static::updated(function () {
            Cache::forget('teams_list');
        });
        static::deleted(function () {
            Cache::forget('teams_list');
        });
        static::deleted(function () {
            Cache::forget('teams_list');
        });
    }

    /** Scope */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    /** Scope */
}
