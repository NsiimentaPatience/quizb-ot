<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['verse_id', 'chapter_id', 'book_id', 'question', 'correct_answer', 'options'];

    public function verse()
    {
        return $this->belongsTo(Verse::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}