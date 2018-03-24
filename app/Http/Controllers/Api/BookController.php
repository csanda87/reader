<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;

class BookController extends Controller
{
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function index()
    {
        return $this->book->all();
    }

    public function destroy($id)
    {
        return $this->book->findOrFail($id)->delete();
    }
}
