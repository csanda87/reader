@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Book</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="/books/{{ $book->id }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{ old('title') ?? $book->title }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="author" value="{{ old('author') ?? $book->author }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="publication_date">Publication Date</label>
                            <input type="date" name="publication_date" value="{{ $book->publication_date }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="image_file">Image</label>
                            <input type="file" name="image_file" class="form-control">
                            @if($book->image)
                                <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}">
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Update Book" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection