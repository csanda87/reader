<?php

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', function() {
	return view('home');
});
