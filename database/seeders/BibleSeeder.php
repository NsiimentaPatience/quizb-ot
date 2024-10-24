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
            // Format the book name (for handling names like "1Corinthians")
            $formattedBookName = $this->formatBookName($bookName);

            // Find or create the category
            $category = Category::firstOrCreate(['name' => $bookData['category']]);

            // Check if the book already exists with the same name and category
            $book = Book::firstOrNew([
                'name' => $formattedBookName,
                'category_id' => $category->id,
            ]);

            // If the book is new, save it to the database
            if (!$book->exists) {
                $book->save();
            }

            // Loop through each chapter in the book
            foreach ($bookData as $chapterKey => $chapterData) {
                // Ensure the chapterKey contains the book name before proceeding
                if (strpos($chapterKey, $formattedBookName) !== false) {
                    // Extract chapter number from the key (e.g., "Ephesians 1" -> 1)
                    $chapterNumber = $this->extractChapterNumber($chapterKey, $formattedBookName);

                    // Check if the chapter already exists within the corresponding book
                    $chapter = Chapter::firstOrNew([
                        'book_id' => $book->id,
                        'chapter_number' => (int)$chapterNumber,
                    ]);

                    // If the chapter is new, save it to the database
                    if (!$chapter->exists) {
                        $chapter->save();
                    }

                    // Loop through each verse in the chapter
                    foreach ($chapterData as $verseNumber => $verseText) {
                        // Check if the verse already exists in the chapter and book
                        $verse = Verse::firstOrNew([
                            'chapter_id' => $chapter->id,
                            'book_id' => $book->id, // Include the book_id here
                            'verse_number' => (int)$verseNumber,
                        ]);

                        // If the verse is new, set the text and save it
                        if (!$verse->exists) {
                            $verse->text = $verseText;
                            $verse->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * Format the book name to handle concatenated names like "1Corinthians" or "2Timothy".
     */
    protected function formatBookName($bookName)
    {
        // Add a space between number and book name if it's missing (e.g., "1Corinthians" -> "1 Corinthians")
        return preg_replace('/(\d)([A-Za-z])/', '$1 $2', $bookName);
    }

    /**
     * Extract the chapter number from a key like "1 Corinthians 1" or "Song of Solomon 2".
     */
    protected function extractChapterNumber($chapterKey, $bookName)
    {
        // Split the chapterKey to extract the chapter number after the book name
        $parts = explode(' ', $chapterKey);
        
        // The last part should be the chapter number
        return end($parts);
    }
}
