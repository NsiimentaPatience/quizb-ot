<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = ['review_id', 'user_id', 'content'];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship to Review
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

}
