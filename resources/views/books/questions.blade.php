@extends('components.layout')

@section('title', 'The book of {{ $book->name }}')

@section('content')
<link rel="stylesheet" href="{{ asset('css/questions.css') }}">

<div class="container">
    <h2 class="my-4 text-center">The book of {{ $book->name }}</h2>

    <div class="d-flex flex-column align-items-center">
        @foreach($questions as $question)
            <div class="question-card card p-4 mb-4 text-center">
                <p class="question-text">{{ $question['text'] }}</p>
                <div class="d-flex flex-column">
                    @foreach($question['options'] as $option)
                        @php
                            $selectedAnswer = session("selected_answers.{$question['text']}");
                            $buttonClass = '';
                            // Check if the current option is the one the user selected
                            if ($selectedAnswer) {
                                if ($option === $selectedAnswer && $selectedAnswer === $question['correct_answer']) {
                                    $buttonClass = 'correct'; // Green if correct and selected
                                } elseif ($option === $selectedAnswer && $selectedAnswer !== $question['correct_answer']) {
                                    $buttonClass = 'incorrect'; // Red if selected but wrong
                                } elseif ($option === $question['correct_answer']) {
                                    $buttonClass = 'correct'; // Green for the correct answer when wrong option was selected
                                }
                            }
                        @endphp
                        <a href="#" class="btn btn-option mb-2 {{ $buttonClass }}" 
                           data-question="{{ $question['text'] }}" 
                           data-correct="{{ $question['correct_answer'] }}">{{ $option }}</a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-option');

        buttons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default anchor behavior
                const questionText = this.dataset.question;
                const correctAnswer = this.dataset.correct;
                const selectedAnswer = this.innerText;

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
                    // Refresh the page to reflect the new state
                    window.location.reload();
                });
            });
        });
    });
</script>

<style>
    .correct {
        background-color: green; /* Green for correct answer */
        color: white;
    }
    .incorrect {
        background-color: red; /* Red for incorrect answer */
        color: white;
    }
</style>
@endsection
