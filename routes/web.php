<?php
use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::resource('books', BookController::class);
Route::resource('authors',AuthorController::class);