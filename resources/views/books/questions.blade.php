@extends('components.layout')

@section('title', "The book of {$book->name}")

@section('content')
<link rel="stylesheet" href="{{ asset('css/questions.css') }}">


<div class="container">
    <h2 class="my-4 text-center">The book of {{ $book->name }}</h2>

    <!-- Score and Rank Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
        <div>
            <p id="score">Score: {{ session('score', 0) }}</p>
            <p id="rank">Rank: {{ session('rank', 'Beginner') }}</p>
        </div>
    </div>

    <div class="d-flex flex-column align-items-center">
        <div class="question-card card p-4 mb-4 text-center">

            <!-- Display Question -->
            <p class="question-text">{{ $currentQuestion['question'] }}</p>
            
            <!-- Process and Display Verse Reference -->
            @php
            $verseReference = $currentQuestion['verse_reference'] ?? '';
            if ($verseReference) {
                $parts = explode(' ', $verseReference); // Split to get book name and chapter:verse
                $bookName = $parts[0] ?? ''; 
                $chapterVerse = explode(':', $parts[1] ?? ''); // Split by colon to get chapter and verse
                $chapter = $chapterVerse[0] ?? '';
                $verse = $chapterVerse[1] ?? '';

                // Fetch book_id and chapter_id
                $book = \App\Models\Book::where('name', $bookName)->first(); // Get the book object
                $bookId = $book->id ?? null; // Extract book ID

                $chapterId = \App\Models\Chapter::where('book_id', $bookId)->where('chapter_number', $chapter)->value('id');
            }
            @endphp

            <!-- Clickable Verse Reference (Initially disabled) -->
            @if($verseReference && $bookId && $chapterId && $verse)
                <a href="#" class="verse-reference text-muted" data-book-id="{{ $bookId }}" 
                   data-chapter-id="{{ $chapterId }}" data-verse="{{ $verse }}" 
                   style="pointer-events: none;">
                    {{ $verseReference }}
                </a>
            @else
                <p>Reference not available</p>
            @endif

            <!-- Display Fetched Verse Text Here -->
            <div id="verseText" class="mt-3" style="display: none;">
                <p id="verseContent"></p>
            </div>

            <!-- Display Answer Options -->
            <div class="d-flex flex-column">
                @foreach($currentQuestion['options'] as $option)
                    @php
                        $selectedAnswer = session("selected_answers.{$currentQuestion['question']}");
                        $buttonClass = '';
                        if ($selectedAnswer) {
                            if ($option === $selectedAnswer && $selectedAnswer === $currentQuestion['correct_answer']) {
                                $buttonClass = 'correct'; // Green if correct and selected
                            } elseif ($option === $selectedAnswer && $selectedAnswer !== $currentQuestion['correct_answer']) {
                                $buttonClass = 'incorrect'; // Red if selected but wrong
                            } elseif ($option === $currentQuestion['correct_answer']) {
                                $buttonClass = 'correct'; // Green for the correct answer
                            }
                        }
                    @endphp
                    <a href="#" class="btn btn-option mb-2 {{ $buttonClass }}" 
                       data-question="{{ $currentQuestion['question'] }}" 
                       data-correct="{{ $currentQuestion['correct_answer'] }}">{{ $option }}</a>
                @endforeach
            </div>

            <!-- Circular Timer Display -->
            <div class="question-timer my-4">
                <div class="circle">
                    <svg>
                        <circle cx="50" cy="50" r="45"></circle>
                    </svg>
                    <div class="countdown-text" id="countdown">60</div>
                </div>
            </div>

            <!-- Sound Effects -->
            <audio id="correctSound" src="{{ asset('sounds/correct.mp3') }}" preload="auto"></audio>
            <audio id="incorrectSound" src="{{ asset('sounds/incorrect.mp3') }}" preload="auto"></audio>

            <!-- Popup Message -->
            <div id="popupMessage" class="popup" style="display:none;">
                <span id="popupText"></span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-option');
        let timeLimit = 60; // Set the timer to 60 seconds
        const countdownElement = document.getElementById("countdown");
        const circleElement = document.querySelector('circle');
        const FULL_DASH_ARRAY = 283; // Circle circumference (2πr)
        let answerSelected = false; // Track if an answer has been selected

        // Disable the verse reference initially
        const verseReference = document.querySelector('.verse-reference');
        verseReference.style.pointerEvents = 'none'; // Disable the click
        verseReference.classList.add('text-muted'); // Add muted class

        // Function to update the timer every second
        const timerInterval = setInterval(function () {
            timeLimit--;
            countdownElement.innerText = timeLimit; // Update the countdown text

            // Update the circular progress
            setCircleDashoffset();

            if (timeLimit <= 0) {
                clearInterval(timerInterval);
                submitAnswer(); // Automatically submit answer when timer expires
            }
        }, 1000);

        // Function to adjust the stroke-dashoffset for the circular progress
        function setCircleDashoffset() {
            const offset = FULL_DASH_ARRAY - (timeLimit / 60) * FULL_DASH_ARRAY;
            circleElement.style.strokeDashoffset = offset;
        }

        // Function to handle answer submission
        function submitAnswer(selectedAnswer = null) {
            const questionText = buttons.length ? buttons[0].dataset.question : '';
            selectedAnswer = selectedAnswer || null;

            // Store selected answer in session via AJAX
            fetch('/store-answer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    question: questionText,
                    answer: selectedAnswer
                })
            }).then(response => {
                // Move to the next question after the answer is stored
                window.location.reload();
            });
        }

        function showPopup(message) {
            const popup = document.getElementById("popupMessage");
            const popupText = document.getElementById("popupText");
            popupText.innerText = message;
            popup.style.display = "block";
            setTimeout(() => {
                popup.style.display = "none";
            }, 2000); // Popup will show for 2 seconds
        }

        const verseTextContainer = document.getElementById('verseText');
        const verseContent = document.getElementById('verseContent');

        verseReference.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            const bookId = this.dataset.bookId;
            const chapterId = this.dataset.chapterId; // Use chapter_id instead of chapter
            const verse = this.dataset.verse;

            // Send an AJAX request to fetch the verse
            fetch('{{ route('verse.get') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ book_id: bookId, chapter_id: chapterId, verse: parseInt(verse) }) // Send as JSON
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    verseContent.innerText = data.verse_text; // Display the fetched verse text
                    verseTextContainer.style.display = 'block'; // Show the container
                } else {
                    verseContent.innerText = 'Verse not available.';
                    verseTextContainer.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching verse:', error);
                verseContent.innerText = 'Error fetching verse.';
                verseTextContainer.style.display = 'block';
            });
        });

        buttons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default anchor behavior

                // Prevent further selections once an answer is chosen
                if (answerSelected) return; // Exit if an answer has already been chosen

                answerSelected = true; // Mark that an answer has been selected

                // Disable all buttons after a choice is made
                buttons.forEach(btn => {
                    btn.disabled = true; // Disable all buttons
                });

                const questionText = this.dataset.question;
                const correctAnswer = this.dataset.correct;
                const selectedAnswer = this.innerText;

                // Change button colors based on whether the answer is correct or incorrect
                buttons.forEach(btn => {
                    btn.classList.remove('correct', 'incorrect'); // Reset colors first
                    if (btn.innerText === correctAnswer) {
                        btn.classList.add('correct'); // Mark correct option green
                    }
                    if (btn.innerText === selectedAnswer && selectedAnswer !== correctAnswer) {
                        btn.classList.add('incorrect'); // Mark incorrect option red
                    }
                });

                // Play sound and show popup based on the answer selected
                if (selectedAnswer === correctAnswer) {
                    document.getElementById('correctSound').play();
                    showPopup("✔️ Congratulations! Correct answer!"); // Tick symbol for correct answer
                } else {
                    document.getElementById('incorrectSound').play();
                    showPopup("❌ Oops! That's incorrect!"); // X symbol for incorrect answer
                }

                // Enable verse reference once an option is selected
                verseReference.style.pointerEvents = 'auto'; // Enable the click
                verseReference.classList.remove('text-muted'); // Remove muted class

                // Extended delay to allow time to check the verse before moving to the next question
                setTimeout(() => {
                    submitAnswer(selectedAnswer); // Pass the selected answer
                }, 8000); // 8-second delay before loading the next question
            });
        });
    });
</script>
<!-- Circular Timer Styles -->
<style>
    .correct {
        background-color: rgb(197, 250, 197);
        color: white;
    }

    .incorrect {
        background-color: rgb(245, 138, 138);
        color: white;
    }

    .question-timer {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .circle {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .circle svg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .circle svg circle {
        width: 100%;
        height: 100%;
        fill: none;
        stroke-width: 10;
        stroke: #b38ff9; /* Green color */
        stroke-dasharray: 283; /* The circumference of the circle */
        stroke-dashoffset: 0;
        transition: stroke-dashoffset 1s linear;
    }

    .countdown-text {
        font-size: 24px;
        font-weight: bold;
        color:#b38ff9;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Popup Styles */
    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 1000;
    }
</style>

@endsection
