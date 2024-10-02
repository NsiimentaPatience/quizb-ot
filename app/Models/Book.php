<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = ['name', 'category_id'];

    // Define relationship with chapters
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Define relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
