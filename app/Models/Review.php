<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'content'];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship to replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

}
