<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'chapter_number'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function verses()
    {
        return $this->hasMany(Verse::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}