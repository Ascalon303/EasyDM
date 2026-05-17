<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Encounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'campaign_id', 'name', 'difficulty', 'party_data', 'monster_data', 'ai_analysis',
    ];

    protected $casts = [
        'party_data'   => 'array',
        'monster_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getDifficultyColorAttribute(): string
    {
        return match($this->difficulty) {
            'easy'   => 'text-green-400',
            'medium' => 'text-yellow-400',
            'hard'   => 'text-orange-400',
            'deadly' => 'text-red-500',
            default  => 'text-gray-400',
        };
    }
}
