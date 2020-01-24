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

Route::get('/browse', function () {
    return redirect('/');
});;

Auth::routes();

Route::get('search', 'SearchController@search')->name('search');

Route::post('store', 'ItemController@store')->name('store-item');

Route::group(['prefix' => 'items', 'middleware' => 'auth'], function()
{
    Route::get('add', 'ItemController@create')->name('add-item');
});

Route::group(['prefix' => 'items', 'middleware' => 'auth'], function()
{
    Route::get('{id}', 'ItemController@show')->name('show-book');
    Route::get('/', function () {
        return redirect('/browse');
    });
});

//Routes for movies in the library
Route::group(['prefix' => 'movies', 'middleware' => 'auth'], function()
{
    Route::get('create', 'MovieController@create')->name('create-movie');
    Route::get('edit/{id}', 'MovieController@edit')->name('edit-movie');
    Route::post('update/{id}', 'MovieController@update')->name('update-movie');
    Route::get('delete/{id}', 'ItemController@destroy')->name('delete-movie');
    Route::get('browse', 'MovieController@index')->name('browse-movie');
    Route::get('add', 'MovieController@create');
    Route::get('{id}', 'ItemController@show')->name('show-movie');
    Route::get('/', function () {
        return redirect('movies/browse');
    });
});

//Routes for books in the library
Route::group(['prefix' => 'books', 'middleware' => 'auth'], function()
{
    Route::get('create', 'BookController@create')->name('create-book');
    Route::get('edit/{id}', 'BookController@edit')->name('edit-book');
    Route::post('update/{id}', 'BookController@update')->name('update-book');
    Route::get('delete/{id}', 'ItemController@destroy')->name('delete-book');
    Route::get('browse', 'BookController@index')->name('browse-book');
    Route::get('add', 'BookController@create');
    Route::get('{id}', 'ItemController@show')->name('show-book');
    Route::get('/', function () {
        return redirect('/browse');
    });
});
