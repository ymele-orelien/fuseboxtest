<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Panic extends Model
{
    protected $fillable = [
        'longitude',
        'user_id',
        'latitude',
        'panic_type',
        'details',
        'user_name',
        'reference_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
