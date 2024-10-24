<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController; // Ensure you have this controller
use App\Http\Middleware\CheckUserAgreement;

// Route for showing the welcome page (unprotected)
Route::get('/', function () {
    return view('welcome');
});

// Route to display the user agreement page (this should be accessible before agreeing)
Route::get('/user-agreement', function () {
    return view('agreement');
})->name('user-agreement');

// Grouped routes with 'auth' middleware
Route::middleware('auth')->group(function () {

    // Admin Dashboard route
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User agreement submission route (this can be protected if needed)
    Route::post('/user-agreement', [LoginController::class, 'acceptAgreement'])->name('user.agreement.submit');

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
    });
});

// Route for showing the login and signup form (same view for both login and signup)
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

// Route to handle the login form submission
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Route to handle the signup form submission
Route::post('/signup', [LoginController::class, 'signup'])->name('signup.submit');

// Optional logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
