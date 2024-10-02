<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Verse;
use App\Models\Category; // Ensure you have a Category model

class BibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the JSON file
        $filePath = storage_path('app/bible/bible.json');

        // Check if the file exists
        if (!File::exists($filePath)) {
            $this->command->error("The Bible data file does not exist at: {$filePath}");
            return;
        }

        // Load and decode the JSON file
        $bibleData = json_decode(File::get($filePath), true);

        // Check for valid JSON data
        if (!$bibleData) {
            $this->command->error("Invalid JSON data in the file: {$filePath}");
            return;
        }

        // Seed the Bible data
        $this->seedBibleData($bibleData);
    }

    /**
     * Function to seed Bible data
     *
     * @param array $bibleData
     * @return void
     */
    private function seedBibleData(array $bibleData): void
    {
        foreach ($bibleData as $bookName => $bookData) {
            $categoryName = $bookData['category'];
            unset($bookData['category']); // Remove category from bookData

            // Find or create the category
            $category = Category::firstOrCreate(['name' => $categoryName]);

            // Find or create the book with category
            $book = Book::firstOrCreate([
                'name' => $bookName,
                'category_id' => $category->id // Associate category with the book
            ]);

            foreach ($bookData as $chapterName => $verses) {
                // Extract chapter number from the chapter name (e.g., "Ephesians 1" -> 1)
                $chapterNumber = intval($chapterName);

                // Find or create the chapter
                $chapter = Chapter::firstOrCreate([
                    'book_id' => $book->id,
                    'chapter_number' => $chapterNumber
                ]);

                foreach ($verses as $verseNumber => $verseText) {
                    // Find or create each verse
                    Verse::firstOrCreate([
                        'chapter_id' => $chapter->id,
                        'verse_number' => $verseNumber
                    ], [
                        'text' => $verseText
                    ]);
                }
            }
        }
    }
}
