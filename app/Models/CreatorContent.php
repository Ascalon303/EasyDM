<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreatorContent extends Model
{
    use HasFactory;

    protected $fillable = [
    'creator_id', 'title', 'description', 'type', 'price',
    'is_premium', 'content_body', 'rating', 'download_count', 'cover_image',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'price'      => 'decimal:2',
        // content_body tidak perlu di-cast, sudah longText biasa
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function reviews()
    {
        return $this->hasMany(ContentReview::class, 'content_id');
    }
}
