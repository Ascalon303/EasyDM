<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'bio',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helpers
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isDM(): bool    { return $this->role === 'dm'; }
    public function isPlayer(): bool { return $this->role === 'player'; }
    public function isCreator(): bool { return $this->role === 'creator'; }

    // Relationships
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function creatorContents()
    {
        return $this->hasMany(CreatorContent::class, 'creator_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function joinedCampaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_players')->withTimestamps();
    }
}
