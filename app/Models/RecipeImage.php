<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'recipe_id',
        'name',
        'url',
        'content_type',
        'video_id',
        'video_url',
    ];

    // public function images()
    // {
    //     return $this->belongsTo(Recipe::class);
    // }
}
