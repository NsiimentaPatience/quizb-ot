<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Verse;
use App\Models\Question; // Ensure you have a Question model

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the JSON file
        $filePath = storage_path('app/questions/questions.json');

        // Check if the file exists
        if (!File::exists($filePath)) {
            $this->command->error("The questions data file does not exist at: {$filePath}");
            return;
        }

        // Load and decode the JSON file
        $questionsData = json_decode(File::get($filePath), true);

        // Check for valid JSON data
        if (!$questionsData) {
            $this->command->error("Invalid JSON data in the file: {$filePath}");
            return;
        }

        // Seed the questions data
        $this->seedQuestionsData($questionsData);
    }

    /**
     * Function to seed questions data
     *
     * @param array $questionsData
     * @return void
     */
    private function seedQuestionsData(array $questionsData): void
{
    // Get the 'questions' array from the root of the data
    foreach ($questionsData['questions'] as $bookData) {
        // Extract book name
        $bookName = $bookData['book'];

        // Check if the 'questions' key exists for this book
        if (!isset($bookData['questions'])) {
            $this->command->warn("No questions found for the book: {$bookName}");
            continue;
        }

        foreach ($bookData['questions'] as $questionData) {
            // Extract chapter and verse from question data
            $chapterNumber = $questionData['chapter'];
            $verseNumber = $questionData['verse'];

            // Find the corresponding book
            $book = Book::where('name', $bookName)->first();

            if ($book) {
                // Find the corresponding chapter
                $chapter = Chapter::where('book_id', $book->id)
                                  ->where('chapter_number', $chapterNumber)
                                  ->first();

                if ($chapter) {
                    // Find the corresponding verse
                    $verse = Verse::where('chapter_id', $chapter->id)
                                  ->where('verse_number', $verseNumber)
                                  ->first();

                    if ($verse) {
                        // Create the question associated with the verse
                        Question::firstOrCreate([
                            'verse_id' => $verse->id, // Assuming you have a verse_id foreign key in your questions table
                            'chapter_id' => $chapter->id, // Optional, if you want to keep this for reference
                            'book_id' => $book->id, // Optional, if you want to keep this for reference
                        ], [
                            'question' => $questionData['question'],
                            'correct_answer' => $questionData['correct_answer'],
                            'options' => json_encode($questionData['options']) // Assuming options need to be stored as a JSON string
                        ]);
                    }
                }
            }
        }
    }
}

}
