<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;

// Route for displaying the list of books
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Route for showing the welcome page (default route)
Route::get('/', function () {
    return view('welcome');
});

// Route for displaying quiz questions based on book ID
Route::get('/books/{id}/questions', [BookController::class, 'showQuestions'])->name('books.questions');

// Route to store the selected answer for a quiz question
Route::post('/store-answer', [BookController::class, 'storeAnswer'])->name('store-answer');

// Route to display the user agreement page
Route::get('/user-agreement', function () {
    return view('agreement');
})->name('user-agreement');

// Route for showing the login and signup form (same view for both login and signup)
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

// Route to handle the login form submission
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Route to handle the signup form submission
Route::post('/signup', [LoginController::class, 'signup'])->name('signup.submit');

// Optional logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User agreement submission route
Route::post('/user-agreement', [LoginController::class, 'acceptAgreement'])->middleware('auth')->name('user.agreement.submit');
