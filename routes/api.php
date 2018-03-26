<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api']], function () {
	Route::apiResource('/books', 'Api\BookController')->only(['index', 'destroy']);

	Route::post('/reading-list-order', function(Request $request) {
		$books = [];
		
		foreach ($request->all() as $i => $book) {
			$book = App\Book::findOrFail($book['id']);
			$book->order = $i + 1;
			$book->save();

			$books[] = $book;
		}

		return $books;
	});
});
