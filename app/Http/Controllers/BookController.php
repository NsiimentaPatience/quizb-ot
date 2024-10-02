<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Fetch all books from the database
         $books = Book::all();

         // Pass the books to the view
         return view('books.index', compact('books'));
    }
    public function showQuestions($id)
    {
        // Fetch the selected book by its ID
        $book = Book::findOrFail($id);

        // Generate specific questions based on the book
        $questions = $this->generateQuestions($book->name);

        // Store questions in the session
        session(['questions' => $questions]);

        // Return the view with the questions
        return view('books.questions', compact('book', 'questions'));
    }
    public function storeAnswer(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        // Store selected answers in session
        $selectedAnswers = session('selected_answers', []);
        $selectedAnswers[$request->question] = $request->answer;
        session(['selected_answers' => $selectedAnswers]);

        return response()->json(['success' => true]);
    }

    private function generateQuestions($bookName)
    {
        $questions = [];

        switch ($bookName) {
            case 'Genesis':
                $questions = [
                    [
                        'text' => 'Who was the father of Abraham?',
                        'options' => $this->shuffleOptions(['Terah', 'Nahor', 'Haran', 'Isaac']),
                        'correct_answer' => 'Terah',
                        'verse_reference' => 'Genesis 11:27'
                    ],
                    [
                        'text' => 'What did God create on the seventh day?',
                        'options' => $this->shuffleOptions(['Humans', 'Animals', 'Heaven and Earth', 'Rest']),
                        'correct_answer' => 'Rest',
                        'verse_reference' => 'Genesis 2:2-3'
                    ],
                    // Add more questions for Genesis...
                ];
                break;

            case 'Ezra':
                $questions = [
                    [
                        'text' => 'Who led the first group of exiles back to Jerusalem?',
                        'options' => $this->shuffleOptions(['Ezra', 'Nehemiah', 'Zerubbabel', 'Joshua']),
                        'correct_answer' => 'Zerubbabel',
                        'verse_reference' => 'Ezra 1:11'
                    ],
                    [
                        'text' => 'What was Ezra’s profession?',
                        'options' => $this->shuffleOptions(['Priest', 'King', 'Prophet', 'Scribe']),
                        'correct_answer' => 'Scribe',
                        'verse_reference' => 'Ezra 7:6'
                    ],
                    // Add more questions for Ezra...
                ];
                break;

            case 'Numbers':
                $questions = [
                    [
                        'text' => 'How many spies were sent to Canaan?',
                        'options' => $this->shuffleOptions(['12', '10', '14', '8']),
                        'correct_answer' => '12',
                        'verse_reference' => 'Numbers 13:1-2'
                    ],
                    [
                        'text' => 'Who was swallowed by a great fish?',
                        'options' => $this->shuffleOptions(['Jonah', 'Moses', 'Noah', 'Balaam']),
                        'correct_answer' => 'Jonah',
                        'verse_reference' => 'Numbers 22:32'
                    ],
                    // Add more questions for Numbers...
                ];
                break;

            case 'Judges':
                $questions = [
                    [
                        'text' => 'Who was the strongest judge of Israel?',
                        'options' => $this->shuffleOptions(['Gideon', 'Samson', 'Ehud', 'Deborah']),
                        'correct_answer' => 'Samson',
                        'verse_reference' => 'Judges 16:30'
                    ],
                    [
                        'text' => 'What did Gideon use to test God?',
                        'options' => $this->shuffleOptions(['A fleece', 'A sword', 'A fire', 'A dream']),
                        'correct_answer' => 'A fleece',
                        'verse_reference' => 'Judges 6:36-40'
                    ],
                    // Add more questions for Judges...
                ];
                break;

            case 'Nehemiah':
                $questions = [
                    [
                        'text' => 'What was Nehemiah’s role in rebuilding Jerusalem?',
                        'options' => $this->shuffleOptions(['Governor', 'High Priest', 'King', 'Prophet']),
                        'correct_answer' => 'Governor',
                        'verse_reference' => 'Nehemiah 5:14'
                    ],
                    [
                        'text' => 'How long did it take to rebuild the wall?',
                        'options' => $this->shuffleOptions(['52 days', '70 days', '1 year', '3 months']),
                        'correct_answer' => '52 days',
                        'verse_reference' => 'Nehemiah 6:15'
                    ],
                    // Add more questions for Nehemiah...
                ];
                break;

            case 'Romans':
                $questions = [
                    [
                        'text' => 'What does Paul say is the wages of sin?',
                        'options' => $this->shuffleOptions(['Death', 'Separation', 'Sorrow', 'Destruction']),
                        'correct_answer' => 'Death',
                        'verse_reference' => 'Romans 6:23'
                    ],
                    [
                        'text' => 'What does Paul urge the Romans to be transformed by?',
                        'options' => $this->shuffleOptions(['The Holy Spirit', 'The Law', 'The renewal of their mind', 'Their actions']),
                        'correct_answer' => 'The renewal of their mind',
                        'verse_reference' => 'Romans 12:2'
                    ],
                    // Add more questions for Romans...
                ];
                break;

            case 'Galatians':
                $questions = [
                    [
                        'text' => 'What is the fruit of the Spirit according to Paul?',
                        'options' => $this->shuffleOptions(['Love, joy, peace', 'Faith, hope, love', 'Wisdom, knowledge, understanding', 'Power, authority, strength']),
                        'correct_answer' => 'Love, joy, peace',
                        'verse_reference' => 'Galatians 5:22-23'
                    ],
                    [
                        'text' => 'What does Paul warn against in Galatians?',
                        'options' => $this->shuffleOptions(['Legalism', 'Idolatry', 'Greed', 'Immorality']),
                        'correct_answer' => 'Legalism',
                        'verse_reference' => 'Galatians 1:6'
                    ],
                    // Add more questions for Galatians...
                ];
                break;

            case 'Acts':
                $questions = [
                    [
                        'text' => 'Who was the first Christian martyr?',
                        'options' => $this->shuffleOptions(['Stephen', 'James', 'Peter', 'Paul']),
                        'correct_answer' => 'Stephen',
                        'verse_reference' => 'Acts 7:59-60'
                    ],
                    [
                        'text' => 'What happened at Pentecost?',
                        'options' => $this->shuffleOptions(['The Holy Spirit came upon the apostles', 'Jesus was crucified', 'The temple was rebuilt', 'The law was given']),
                        'correct_answer' => 'The Holy Spirit came upon the apostles',
                        'verse_reference' => 'Acts 2:1-4'
                    ],
                    // Add more questions for Acts...
                ];
                break;

            case 'Job':
                $questions = [
                    [
                        'text' => 'What did Job lose in a single day?',
                        'options' => $this->shuffleOptions(['His wealth', 'His health', 'His family', 'His friends']),
                        'correct_answer' => 'His family',
                        'verse_reference' => 'Job 1:18-19'
                    ],
                    [
                        'text' => 'Who were Job\'s three friends who came to comfort him?',
                        'options' => $this->shuffleOptions(['Eliphaz, Bildad, Zophar', 'Elihu, Job, Bildad', 'Job, Noah, Abraham', 'Moses, Aaron, Job']),
                        'correct_answer' => 'Eliphaz, Bildad, Zophar',
                        'verse_reference' => 'Job 2:11'
                    ],
                    // Add more questions for Job...
                ];
                break;

            case 'Leviticus':
                $questions = [
                    [
                        'text' => 'What is the main focus of the book of Leviticus?',
                        'options' => $this->shuffleOptions(['Laws and rituals', 'History of Israel', 'Poetry', 'Prophecy']),
                        'correct_answer' => 'Laws and rituals',
                        'verse_reference' => 'Leviticus 1:1'
                    ],
                    [
                        'text' => 'What was the primary purpose of the Day of Atonement?',
                        'options' => $this->shuffleOptions(['To celebrate harvest', 'To confess sins', 'To remember the Exodus', 'To offer thanksgiving']),
                        'correct_answer' => 'To confess sins',
                        'verse_reference' => 'Leviticus 16:30'
                    ],
                    // Add more questions for Leviticus...
                ];
                break;

            case 'Isaiah':
                $questions = [
                    [
                        'text' => 'Who is the prophet that foretold the coming of the Messiah?',
                        'options' => $this->shuffleOptions(['Jeremiah', 'Ezekiel', 'Isaiah', 'Daniel']),
                        'correct_answer' => 'Isaiah',
                        'verse_reference' => 'Isaiah 7:14'
                    ],
                    [
                        'text' => 'What is the "Suffering Servant" a reference to in Isaiah?',
                        'options' => $this->shuffleOptions(['A king', 'A prophet', 'The Messiah', 'A priest']),
                        'correct_answer' => 'The Messiah',
                        'verse_reference' => 'Isaiah 53'
                    ],
                    // Add more questions for Isaiah...
                ];
                break;

            case 'Joshua':
                $questions = [
                    [
                        'text' => 'Who succeeded Moses as the leader of Israel?',
                        'options' => $this->shuffleOptions(['Aaron', 'Joshua', 'Caleb', 'Gideon']),
                        'correct_answer' => 'Joshua',
                        'verse_reference' => 'Joshua 1:1-2'
                    ],
                    [
                        'text' => 'What city’s walls fell after the Israelites marched around it for seven days?',
                        'options' => $this->shuffleOptions(['Jericho', 'Ai', 'Hebron', 'Jerusalem']),
                        'correct_answer' => 'Jericho',
                        'verse_reference' => 'Joshua 6:20'
                    ],
                    // Add more questions for Joshua...
                ];
                break;

            case 'Ephesians':
                $questions = [
                    [
                        'text' => 'What does Paul describe as the "armor of God"?',
                        'options' => $this->shuffleOptions(['Spiritual tools', 'Physical weapons', 'Knowledge', 'Wealth']),
                        'correct_answer' => 'Spiritual tools',
                        'verse_reference' => 'Ephesians 6:11'
                    ],
                    [
                        'text' => 'What is the primary theme of Ephesians?',
                        'options' => $this->shuffleOptions(['Faith', 'Grace', 'Unity in Christ', 'Law']),
                        'correct_answer' => 'Unity in Christ',
                        'verse_reference' => 'Ephesians 4:4-6'
                    ],
                    // Add more questions for Ephesians...
                ];
                break;

            case 'Deuteronomy':
                $questions = [
                    [
                        'text' => 'What is the meaning of the name "Deuteronomy"?',
                        'options' => $this->shuffleOptions(['Second law', 'First law', 'New covenant', 'Old covenant']),
                        'correct_answer' => 'Second law',
                        'verse_reference' => 'Deuteronomy 17:18'
                    ],
                    [
                        'text' => 'What did Moses remind the Israelites to do before entering the Promised Land?',
                        'options' => $this->shuffleOptions(['To forget the past', 'To obey God\'s commandments', 'To build temples', 'To offer sacrifices']),
                        'correct_answer' => 'To obey God\'s commandments',
                        'verse_reference' => 'Deuteronomy 6:1-2'
                    ],
                    // Add more questions for Deuteronomy...
                ];
                break;
            case 'Esther':
                $questions = [
                    [
                        'text' => 'Who was the queen of Persia that saved the Jewish people?',
                        'options' => $this->shuffleOptions(['Esther', 'Vashti', 'Deborah', 'Rachel']),
                        'correct_answer' => 'Esther',
                        'verse_reference' => 'Esther 4:14'
                    ],
                    [
                        'text' => 'What was the name of Esther’s cousin who raised her?',
                        'options' => $this->shuffleOptions(['Mordecai', 'Haman', 'Nehemiah', 'Ezra']),
                        'correct_answer' => 'Mordecai',
                        'verse_reference' => 'Esther 2:7'
                    ],
                    [
                        'text' => 'Who plotted to destroy the Jews during Esther’s time?',
                        'options' => $this->shuffleOptions(['Haman', 'Saul', 'David', 'Ahasuerus']),
                        'correct_answer' => 'Haman',
                        'verse_reference' => 'Esther 3:5-6'
                    ],
                    [
                        'text' => 'What did Esther risk by approaching the king without being summoned?',
                        'options' => $this->shuffleOptions(['Death', 'Imprisonment', 'Exile', 'Poverty']),
                        'correct_answer' => 'Death',
                        'verse_reference' => 'Esther 4:11'
                    ],
                    [
                        'text' => 'What feast was established to celebrate the deliverance of the Jews?',
                        'options' => $this->shuffleOptions(['Purim', 'Passover', 'Pentecost', 'Tabernacles']),
                        'correct_answer' => 'Purim',
                        'verse_reference' => 'Esther 9:26-28'
                    ],
                    // Add more questions for Esther...
                ];
                break;
                

            default:
                // Handle case where book is not found or has no questions
                break;
        }

        return array_slice($questions, 0, 10);  // Example: return 10 random questions
    }

    private function shuffleOptions($options)
    {
        shuffle($options);  // Randomize the order of the options
        return $options;
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
