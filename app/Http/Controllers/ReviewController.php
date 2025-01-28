<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index()
    {
        // Fetch all reviews with their replies and user information
        $reviews = Review::with(['replies', 'user'])->latest()->get();

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review added successfully.');
    }

    /**
     * Store a reply to a specific review.
     */
    public function reply(Request $request, $reviewId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Reply::create([
            'review_id' => $reviewId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Reply added successfully.');
    }
}
