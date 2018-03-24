@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex flex-row-reverse">
                <div class="p-2">
                    <a href="/books/{{ $book->id }}/edit" class="btn btn-primary">
                        <svg class="i-edit" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z"></path>
                        </svg>
                        Edit Book
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    @if($book->image)
                        <img class="img-fluid" src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}">
                    @else
                        <img class="img-fluid" src="http://via.placeholder.com/350x500" alt="{{ $book->title }}">
                    @endif
                </div>
                <div class="col-md-8">
                    <h1 class="mt-0">{{ $book->title }}</h1>
                    <ul class="list-unstyled">
                        <li><b>Author:</b> {{ $book->author }}</li>
                        @if($book->publication_date)
                            <li><b>Publication Date:</b> {{ $book->publication_date }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection