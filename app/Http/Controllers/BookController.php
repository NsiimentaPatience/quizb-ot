<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Verse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Define an array of book names in the order they appear in the Bible
            $bookOrder = [
                'Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy',
                'Joshua', 'Judges', 'Ruth', '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', 
                '1 Chronicles', '2 Chronicles', 'Ezra', 'Nehemiah', 'Esther', 
                'Job', 'Psalms', 'Proverbs', 'Ecclesiastes', 'Song of Solomon', 
                'Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 
                'Hosea', 'Joel', 'Amos', 'Obadiah', 'Jonah', 'Micah', 'Nahum', 
                'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 'Malachi',
                'Matthew', 'Mark', 'Luke', 'John', 'Acts', 'Romans', '1 Corinthians', 
                '2 Corinthians', 'Galatians', 'Ephesians', 'Philippians', 'Colossians', 
                '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy', 
                'Titus', 'Philemon', 'Hebrews', 'James', '1 Peter', '2 Peter', 
                '1 John', '2 John', '3 John', 'Jude', 'Revelation'
            ];

            // Fetch books from the database in the order specified in the array
            $books = Book::whereIn('name', $bookOrder)
                        ->orderByRaw("FIELD(name, '" . implode("','", $bookOrder) . "')")
                        ->get();

            // Pass the books to the view
            return view('books.index', compact('books'));
        }

    public function showQuestions($id)
    {
        // Fetch the selected book by its ID
        $book = Book::findOrFail($id);

        // Check if the current session is for a different book
        $currentBookId = session('current_book_id');
        if ($currentBookId != $id) {
            // Reset questions and question index for a new book
            session()->forget(['questions', 'current_question_index', 'score', 'correct_streak', 'wrong_streak', 'question_timer', 'rank']);
            session(['current_book_id' => $id, 'score' => 0, 'correct_streak' => 0, 'wrong_streak' => 0, 'rank' => 'Beginner']);
        }

        // Retrieve questions along with their related verses and books
        $questions = session('questions', function() use ($book) {
            // Eager load verses along with questions
            $dbQuestions = Question::with(['verse', 'verse.chapter', 'verse.book'])
                ->where('book_id', $book->id)
                ->get()
                ->toArray();

            // Shuffle the options for each question
            foreach ($dbQuestions as &$question) {
                // Shuffle options
                $question['options'] = $this->shuffleOptions(json_decode($question['options'], true));

                // Generate the verse reference in the format "Book Chapter:Verse"
                if ($question['verse']) {
                    $verse = $question['verse'];
                    $chapter = $verse['chapter']; // Get the related chapter
                    $bookName = $verse['book']['name']; // Get the related book name
                    $question['verse_reference'] = "{$bookName} {$chapter['chapter_number']}:{$verse['verse_number']}";
                } else {
                    $question['verse_reference'] = "N/A"; // Handle the case where verse is not found
                }

                // Store the verse reference in the session as well
                session()->put("verse_reference.{$question['id']}", $question['verse_reference']);
            }
            return $dbQuestions;
        });

        session(['questions' => $questions]);

        // Get the current question index from the session, defaulting to 0
        $currentQuestionIndex = session('current_question_index', 0);

        // If the user has completed all the questions, redirect them to a completion page
        if ($currentQuestionIndex >= count($questions)) {
            return redirect()->route('quiz.completed', ['book' => $id]);
        }

        // Get the current question based on the index
        $currentQuestion = $questions[$currentQuestionIndex];

        // Store the corresponding verse reference of the current question in the session
        $currentQuestion['verse_reference'] = session("verse_reference.{$currentQuestion['id']}");

        // Start a timer for the current question (1 minute)
        session(['question_timer' => now()->addMinutes(1)]);

        // Pass the current question, book details, and the timer to the view
        return view('books.questions', compact('book', 'currentQuestion'));
    }

    public function quizCompleted($bookId)
    {
        // Fetch the book details (optional)
        $book = Book::findOrFail($bookId);

        // Clear the session data
        session()->forget(['current_question_index', 'selected_answers', 'score', 'correct_streak', 'wrong_streak', 'question_timer', 'rank']);

        return view('books.completed', compact('book'));
    }

    public function storeAnswer(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        // Check if the timer has expired
        $timerExpired = $this->hasTimerExpired();
        $currentQuestionIndex = session('current_question_index', 0);
        $questions = session('questions', []);
        $currentQuestion = $questions[$currentQuestionIndex] ?? null;

        // Initialize scoring variables
        $score = session('score', 0);
        $correctStreak = session('correct_streak', 0);
        $wrongStreak = session('wrong_streak', 0);
        $timeTaken = now()->diffInSeconds(session('question_timer')); // Time taken to answer

        if ($currentQuestion) {
            // Check the answer
            if ($request->answer === $currentQuestion['correct_answer']) {
                // Correct answer
                $score += 10; // +10 points for correct answer

                // Speed bonus
                if ($timeTaken <= 10) {
                    $score += 5; // +5 points if answered within 10 seconds
                }

                // Update correct streak
                $correctStreak++;
                if ($correctStreak % 3 === 0) {
                    $score += 5; // +5 points for every 3 consecutive correct answers
                }
                $wrongStreak = 0; // Reset wrong streak
            } else {
                // Incorrect answer
                $score -= 5; // -5 points for incorrect answer
                $wrongStreak++;

                // Wrong streak penalty
                if ($wrongStreak === 3) {
                    $score -= 10; // Lose an additional 10 points after 3 consecutive wrong answers
                }

                $correctStreak = 0; // Reset correct streak
            }

            // Time penalties
            if ($timeTaken > 20) {
                $score -= 2 * ($timeTaken - 20); // Lose 2 points for every second over 20 seconds
            }
        }

        // Determine the new rank based on the updated score
        $rank = $this->determineRank($score);

        // Store updated score, rank, and streaks in session
        session(['score' => $score, 'correct_streak' => $correctStreak, 'wrong_streak' => $wrongStreak, 'rank' => $rank]);

        // Increment the current question index
        session(['current_question_index' => $currentQuestionIndex + 1]);
        session()->forget('question_timer'); // Reset the timer

        return response()->json(['success' => true, 'score' => $score, 'rank' => $rank]); // Return the updated score and rank
    }

    /**
     * Check if the question timer has expired.
     */
    public function hasTimerExpired()
    {
        $timer = session('question_timer');
        return $timer ? now()->greaterThanOrEqualTo($timer) : false;
    }

    /**
     * Shuffle the options for a question.
     */
    private function shuffleOptions($options)
    {
        shuffle($options);  // Randomize the order of the options
        return $options;
    }

    /**
     * Determine the rank based on the current score.
     */
    private function determineRank($score)
    {
        if ($score >= 1001) {
            return 'Master';
        } elseif ($score >= 501) {
            return 'Scholar';
        } elseif ($score >= 101) {
            return 'Disciple';
        } else {
            return 'Beginner';
        }
    }

    /**
     * Fetch the verse text based on the provided verse reference.
     */
    public function getVerse(Request $request)
    {
        // Log the incoming request data
        Log::info('Received request for verse:', $request->all());

        // Validate the incoming request
        try {
            $validatedData = $request->validate([
                'book_id' => 'required|integer',
                'chapter_id' => 'required|integer',
                'verse' => 'required|integer',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation error.']);
        }

        // Log the validated data
        Log::info('Validated data:', $validatedData);

        // Fetch the verse text from the database
        try {
            $verseText = DB::table('verses')
                ->where('book_id', $validatedData['book_id'])
                ->where('chapter_id', $validatedData['chapter_id'])
                ->where('verse_number', $validatedData['verse'])
                ->value('text'); // Adjust 'text' to the actual column name

            if ($verseText) {
                Log::info('Verse found:', ['verse_text' => $verseText]);
                return response()->json(['success' => true, 'verse_text' => $verseText]);
            } else {
                Log::warning('Verse not found for:', $validatedData);
                return response()->json(['success' => false, 'message' => 'Verse not found.']);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching verse:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error fetching verse.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}