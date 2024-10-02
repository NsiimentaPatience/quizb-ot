<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = ['text', 'verse_number', 'chapter_id'];

    // Define relationship with chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
