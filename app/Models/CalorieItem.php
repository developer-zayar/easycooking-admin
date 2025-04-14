<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'category',
        'category_key',
        'weight',
        'calories'
    ];
}
