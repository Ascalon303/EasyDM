<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'world_name', 'status', 'cover_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'campaign_players');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'planning'  => 'badge-warning',
            'active'    => 'badge-success',
            'paused'    => 'badge-secondary',
            'completed' => 'badge-info',
            default     => 'badge-secondary',
        };
    }
}
