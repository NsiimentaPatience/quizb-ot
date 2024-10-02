<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = ['chapter_number', 'book_id'];

    // Define relationship with verses
    public function verses()
    {
        return $this->hasMany(Verse::class);
    }

    // Define relationship with book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}