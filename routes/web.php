<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

//Routes for movies in the library
Route::group(['prefix' => 'movies', 'middleware' => 'auth'], function()
{
    Route::get('create', 'MovieController@create')->name('create-movie');
    Route::post('store', 'MovieController@store')->name('store-movie');
    Route::get('edit/{id}', 'MovieController@edit')->name('edit-movie');
    Route::post('update/{id}', 'MovieController@update')->name('update-movie');
    Route::get('delete/{id}', 'MovieController@destroy')->name('delete-movie');
    Route::get('browse', 'MovieController@index')->name('browse-movie');
    Route::get('search', ['as' => '/movies/search', 'uses' => 'SearchController@movieSearch']);
    Route::get('add', 'MovieController@create');
    Route::get('{id}', 'MovieController@show')->name('show-movie');
    Route::get('/', function () {
        return redirect('movies/browse');
    });
});

//Routes for books in the library
Route::group(['prefix' => 'books', 'middleware' => 'auth'], function()
{
    Route::get('create', 'BookController@create')->name('create-book');
    Route::post('store', 'BookController@store')->name('store-book');
    Route::get('edit/{id}', 'BookController@edit')->name('edit-book');
    Route::post('update/{id}', 'BookController@update')->name('update-book');
    Route::get('delete/{id}', 'BookController@destroy')->name('delete-book');
    Route::get('/browse', 'BookController@index')->name('browse-book');
    Route::get('/search', ['as' => '/books/search', 'uses' => 'SearchController@bookSearch']);
    Route::get('/add', 'BookController@create');
    Route::get('{id}', 'BookController@show')->name('show-book');
    Route::get('/', function () {
        return redirect('/browse');
    });
});
