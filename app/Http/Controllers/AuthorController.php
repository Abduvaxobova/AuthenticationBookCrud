<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }
    public function create()
    {
        return view('authors.create');
    }
    public function store(AuthorStoreRequest $request)
    {
        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->bio = $request->bio;
        $author->save();
        return redirect()->route('authors.index');
    }
    public function show(string $id){
        $author = Author::with('books')->findOrFail($id);
        return view('authors.show', compact('author'));
    }
    public function edit(string $id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'))
            ->with([
                'books' => Book::all()
            ])
        ;
    }
    public function update(AuthorUpdateRequest $request, string $id)
    {
        $author = Author::findOrFail($id);

        $author->name = $request->name;
        $author->email = $request->email;
        $author->bio = $request->bio;
        $author->save();
        if ($request->has('books')) {
            $author->books()->sync($request->books);
        } else {
            $author->books()->detach();
        }
        return redirect()->route('authors.index');
    }
    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return redirect()->route('authors.index');
    }
}
