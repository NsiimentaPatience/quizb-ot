<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verse_id')->constrained()->onDelete('cascade'); // Foreign key to verses table
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade'); // Foreign key to chapters table
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Foreign key to books table
            $table->string('question');
            $table->string('correct_answer');
            $table->json('options'); // Store multiple options as JSON
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};