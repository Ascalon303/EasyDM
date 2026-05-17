<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'campaign_id', 'name', 'race', 'class', 'level',
        'background', 'max_hp', 'current_hp', 'armor_class',
        'ability_scores', 'inventory', 'spells', 'notes',
    ];

    protected $casts = [
        'ability_scores' => 'array',
        'inventory'      => 'array',
        'spells'         => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getHpPercentageAttribute(): int
    {
        if ($this->max_hp === 0) return 0;
        return (int)(($this->current_hp / $this->max_hp) * 100);
    }
}
