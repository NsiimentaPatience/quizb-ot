{{-- resources/views/reviews/index.blade.php --}}
@extends('components.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Leave a Review</h2>

    <!-- Review submission form -->
    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" placeholder="Write your review..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>

    <hr class="my-4">

    <!-- Display all reviews with user info and replies -->
    <h3>Reviews</h3>
    @foreach($reviews as $review)
        <div class="border p-3 mb-3">
            <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('storage/' . $review->user->profile_picture) }}" 
                     alt="{{ $review->user->username }}" 
                     class="rounded-circle" 
                     width="50" 
                     height="50">
                <strong class="ms-3">{{ $review->user->username }}</strong>
            </div>
            <p>{{ $review->content }}</p>
            <p class="text-muted">Posted on {{ $review->created_at->format('F j, Y, g:i a') }}</p>

            <!-- Replies Section -->
            <div class="ms-4">
                @if($review->replies->isNotEmpty())
                    @foreach($review->replies as $reply)
                        <div class="border p-2 mb-2">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('storage/' . $reply->user->profile_picture) }}" 
                                     alt="{{ $reply->user->username }}" 
                                     class="rounded-circle" 
                                     width="40" 
                                     height="40">
                                <strong class="ms-3">{{ $reply->user->username }}</strong>
                            </div>
                            <p>{{ $reply->content }}</p>
                            <p class="text-muted">Replied on {{ $reply->created_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No replies yet.</p>
                @endif

                <!-- Reply submission form for each review -->
                <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <textarea name="content" class="form-control" placeholder="Reply to this review..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm">Reply</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
