<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = ['name'];

    // Define relationship with books
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
