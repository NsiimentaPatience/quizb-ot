<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Book;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Verse;

class BibleSeeder extends Seeder
{
    public function run()
    {
        // Load the JSON file from the storage path
        $jsonPath = storage_path('app/bible/bible.json');
        $json = File::get($jsonPath);
        $data = json_decode($json, true);

        foreach ($data as $bookName => $bookData) {
            // Find or create the category
            $category = Category::firstOrCreate(['name' => $bookData['category']]);

            // Find or create the book with the category_id
            $book = Book::firstOrCreate([
                'name' => $bookName,
                'category_id' => $category->id,
            ]);

            // Loop through each chapter in the book
            foreach ($bookData as $chapterKey => $chapterData) {
                if (strpos($chapterKey, $bookName) !== false) {
                    // Extract chapter number from the key (e.g., "Ephesians 1" -> 1)
                    $chapterNumber = explode(' ', $chapterKey)[1];

                    // Find or create the chapter associated with the book
                    $chapter = Chapter::firstOrCreate([
                        'book_id' => $book->id,
                        'chapter_number' => (int)$chapterNumber,
                    ]);

                    // Loop through each verse in the chapter
                    foreach ($chapterData as $verseNumber => $verseText) {
                        // Use firstOrCreate to avoid duplicates for verses
                        Verse::firstOrCreate([
                            'chapter_id' => $chapter->id,
                            'book_id' => $book->id, // Include the book_id here
                            'verse_number' => (int)$verseNumber,
                        ], [
                            'text' => $verseText, // The text will only be set if the verse doesn't already exist
                        ]);
                    }
                }
            }
        }
    }
}
