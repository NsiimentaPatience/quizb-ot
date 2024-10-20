<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    use HasFactory;

    protected $fillable = ['chapter_id', 'verse_number', 'text'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}