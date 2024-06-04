<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoEat extends Model
{
    use HasFactory;

    protected $fillable = [
        'item1',
        'item2',
        'item1image',
        'item2image',
        'action',
        'status',
    ];
}
