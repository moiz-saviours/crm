<?php

namespace App\Models;

use App\Traits\ActivityLoggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class EmailLabel extends Model
{
    use Notifiable, SoftDeletes, ActivityLoggable;

    protected $table = 'email_labels';
    protected $guarded = [];
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo_record_id',
        'name',
        'color',
        'order',
    ];
    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Relationships
     */
    public function pseudoRecord()
    {
        return $this->belongsTo(UserPseudoRecord::class, 'pseudo_record_id', 'id');
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class, EmailLabelPivot::class, 'label_id', 'email_id', 'id', 'id')
            ->withTimestamps();
    }
}
