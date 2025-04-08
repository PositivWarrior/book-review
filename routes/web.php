<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class)
    ->only(['index', 'show']);

// Books review routes with throttling only on the store route
Route::resource('books.reviews', ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only(['create']);

Route::middleware('throttle:reviews')->group(function () {
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('books.reviews.store');
});
