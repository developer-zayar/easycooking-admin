<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'rating',
        'comment',
    ];

    // public function post()
    // {
    //     return $this->belongsTo(Post::class);
    // }
}
