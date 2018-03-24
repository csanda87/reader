@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex flex-row-reverse">
                <div class="p-2">
                    <a href="/books/create" class="btn btn-primary">Add Book</a>
                </div>
            </div>
            <book-index></book-index>
        </div>
    </div>
</div>


@endsection