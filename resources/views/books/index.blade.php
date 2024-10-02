@extends('components.layout')

@section('title', 'Home')

@section('content')
<link rel="stylesheet" href="{{ asset('css/books.css') }}">

<div class="container">
    <div class="row">
        @foreach($books as $book)
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <a href="{{ route('books.questions', $book->id) }}" class="btn btn-book w-100">
                    {{ $book->name }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
