<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id'
    ];

    // Return the friend's user record
    public function friendUser()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    // The main user
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
