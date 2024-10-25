<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Controllers\AuthorController;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('authors')->get();
        return view('books.index', compact('books'));
    }
    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }
    public function store(BookStoreRequest $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->save();
        if (isset($request->authors)) {
            foreach ($request->authors as $author) {
                $book->authors()->attach([$author]);
            }
        }
        return redirect()->route('books.index');
    }
    public function show(string $id)
    {
        $book = Book::with('authors')->findOrFail($id);
        return view('books.show', compact('book'));
    }
    public function edit(string $id)
    {
        $book = Book::findOrFail($id); 
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }
    public function update(BookUpdateRequest $request, string $id)
    {
        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->description = $request->description;
        $book->save();
        if (isset($request->authors) && !empty($request->authors)) {
            $book->authors()->sync($request->authors);
        }
        return redirect()->route('books.index');
    }
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index');
    }
}