<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReplyController;
use App\Http\Middleware\CheckUserAgreement;


// Route to display the user agreement page
Route::get('/user-agreement', function () {
    return view('agreement');
})->name('user-agreement');

// Grouped routes with 'auth' middleware
Route::middleware('auth')->group(function () {

    // Admin Dashboard route (no user agreement check)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User agreement submission route
    Route::post('/user-agreement', [LoginController::class, 'acceptAgreement'])->name('user.agreement.submit');

    // User management routes (no user agreement check)
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index'); // View all users
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update'); // Update a user
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy'); // Delete a user

    // Ensure the user has accepted the agreement before accessing these routes
    Route::middleware(CheckUserAgreement::class)->group(function () {
        
        // Route for displaying the list of books
        Route::get('/books', [BookController::class, 'index'])->name('books.index');

        // Route for displaying quiz questions based on book ID
        Route::get('/books/{id}/questions', [BookController::class, 'showQuestions'])->name('books.questions');

        // Route to store the selected answer for a quiz question
        Route::post('/store-answer', [BookController::class, 'storeAnswer'])->name('store-answer');

        Route::post('/get-verse', [BookController::class, 'getVerse'])->name('verse.get');

        Route::get('/quiz/completed/{book}', [BookController::class, 'quizCompleted'])->name('quiz.completed');
        Route::post('/resume-questions', [BookController::class, 'resumeQuestions'])->name('quiz.resume');

        // Review routes
        Route::resource('reviews', ReviewController::class)->except(['show']);
        
        // Route for submitting a reply to a review using ReplyController
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    });

    // Route for updating profile picture
    Route::post('/profile/update', [LoginController::class, 'update'])->name('profile.update');
});

// Route for showing the login and signup form
Route::get('/', [LoginController::class, 'showLogin'])->name('login');

// Route to handle the login form submission
Route::post('/', [LoginController::class, 'login'])->name('login.submit');

// Route to handle the signup form submission
Route::post('/signup', [LoginController::class, 'signup'])->name('signup.submit');

// Optional logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
