<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * Store a new reply for a specific review.
     */
    public function store(Request $request, $reviewId)
{
    $request->validate([
        'content' => 'required|string|max:500'
    ]);

    $review = Review::findOrFail($reviewId);

    Reply::create([
        'user_id' => Auth::id(),
        'review_id' => $review->id,
        'content' => $request->content,
    ]);

    return redirect()->route('reviews.index')->with('success', 'Reply added successfully.');
}

}
