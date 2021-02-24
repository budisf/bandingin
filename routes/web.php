<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/books', 'BookController@index')->name('book');
Route::get('/books_show', 'BookController@getAllBook')->name('getBook');
Route::get('/book/{id}/edit', 'BookController@edit');
Route::post('/book/store', 'BookController@store');
Route::post('book/{id}/delete', 'BookController@destroy')->name('book.delete');

Route::get('/libraries', 'LibraryController@index')->name('library');
Route::get('/libraries_show', 'LibraryController@getAllLibrary')->name('getLibrary');
Route::get('/library/{id}/edit', 'LibraryController@edit');
Route::post('/library/store', 'LibraryController@store');
Route::post('library/{id}/delete', 'LibraryController@destroy')->name('library.delete');

Route::get('/library/{id}/add_book', 'DetailLibraryController@show');
Route::post('/library/book/store', 'DetailLibraryController@store');
Route::get('/library/all', 'DetailLibraryController@index')->name('libraries.all');
