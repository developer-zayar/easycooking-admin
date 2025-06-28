<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'name',
        'url',
        'content_type',
        'video_id',
        'video_url',
    ];

    // public function images()
    // {
    //     return $this->belongsTo(Post::class);
    // }
}
