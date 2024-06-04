<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $appends = ['average_rating'];

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(PostReview::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function getAverageRatingAttribute()
    {
        // Assuming you've selected 'average_rating' in your query
        return isset($this->attributes['average_rating']) ? (float) $this->attributes['average_rating'] : 0.0;
    }
}
