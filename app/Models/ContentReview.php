<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentReview extends Model
{
    public $timestamps = false;
    protected $fillable = ['content_id', 'user_id', 'rating', 'review'];

    public function content()
    {
        return $this->belongsTo(CreatorContent::class, 'content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
