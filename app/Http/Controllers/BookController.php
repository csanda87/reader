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
        return $this->book->all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
        ]);

        dd($request->all());
    }

    public function show($id)
    {
        return $this->book->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
        ]);

        dd($request->all());
    }

    public function destroy($id)
    {
        $this->book->findOrFail($id)->delete();

        return response('Successfully removed book id: ' . $id, 200);
    }
}
