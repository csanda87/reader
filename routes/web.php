<?php

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', function() {
	return redirect('/books');
});

Route::resource('/books', 'BookController')->except(['destroy']);