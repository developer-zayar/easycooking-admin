<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'post_id',
        'name',
        'image',
        'content',
        'views',
        'fav',
        'inactive'
    ];

    public function images()
    {
        return $this->hasMany(RecipeImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(RecipeReview::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
