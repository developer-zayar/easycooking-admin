<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'post_id',
        'name',
        'slug',
        'image',
        'description',
        'instructions',
        'prep_time',
        'cook_time',
        'view_count',
        'fav_count',
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

//    protected static function booted()
//    {
//        static::created(function ($recipe) {
//            $recipe->slug = 'recipe-' . $recipe->id . Str::uuid();
//            $recipe->saveQuietly();
//        });
//    }
}
