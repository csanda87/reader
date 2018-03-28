<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function __construct(Book $book)
    {
        $this->middleware('auth');
        $this->book = $book;
    }

    public function index()
    {
        return view('book.index');
    }

    public function create()
    {
        return view('book.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'image_file' => 'image',
        ]);

        if($request->hasFile('image_file')) {
            $image = $this->book->storeBookImage($request->file('image_file'));
            $request->merge(['image' => $image]);
        }

        $request->merge(['user_id' => auth()->user()->id]);
        $this->book->create($request->all());

        return redirect('/books');
    }

    public function show($id)
    {
        $book = $this->book->findOrFail($id);

        return view('book.show')->with([
            'book' => $book
        ]);
    }

    public function edit($id)
    {
        $book = $this->book->findOrFail($id);

        return view('book.edit')->with([
            'book' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = $this->book->findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'image_file' => 'image',
        ]);

        if($request->hasFile('image_file')) {
            $image = $book->storeBookImage($request->file('image_file'));
            $request->merge(['image' => $image]);
        }

        $request->merge(['user_id' => auth()->user()->id]);
        $book->update($request->all());

        return redirect('/books');
    }
}
