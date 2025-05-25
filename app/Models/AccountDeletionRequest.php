<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeletionRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'reason',
        'requested_at',
        'processed',
    ];
    protected $casts = [
        'requested_at' => 'datetime',
        'processed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
