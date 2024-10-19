@extends('components.layout')

@section('title', 'Quiz Completed')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">You have completed the quiz for {{ $book->name }}!</h2>
        <p class="text-center">Thank you for participating.</p>
        <div class="d-flex justify-content-center">
            <a href="{{ route('books.index') }}" class="btn btn-primary">Go Back to Book List</a>
        </div>
    </div>
@endsection
