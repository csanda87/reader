@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Book</div>

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
                    <form action="/books" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="author">Author *</label>
                            <input type="text" name="author" value="{{ old('author') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="publication_date">Publication Date</label>
                            <input type="date" name="publication_date" value="{{ old('publication_date') ?? date('Y-m-d') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="image_file">Image</label>
                            <input type="file" name="image_file" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <svg class="i-plus" viewBox="0 0 32 32" width="12" height="12" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                                    <path d="M16 2 L16 30 M2 16 L30 16"></path>
                                </svg>
                                Add Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection