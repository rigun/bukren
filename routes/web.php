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

Route::get('/', function () {return view('app');});
Route::get('/login', function () {return view('app');});
Route::get('/logout', function () {return view('app');});
Route::get('/sukses', function () {return view('app');});
Route::get('/list/{kategori}', function () {return view('app');});
Route::get('/listbytype/{type}', function () {return view('app');});
Route::get('/detaillist/{slug}', function () {return view('app');});
Route::get('/blog/{slug}', function () {return view('app');});
Route::get('/search/{search}', function () {return view('app');});



Route::group(['prefix' => 'userdashboard'],function(){
    Route::get('/',function () {return view('app');});
    Route::get('/profile', function () {return view('app');});
    Route::get('/book', function () {return view('app');});
    Route::get('/bag', function () {return view('app');});
    Route::get('/chat', function () {return view('app');});
    Route::get('/chat/{token}', function () {return view('app');});
});

Route::group(['prefix' => 'dashboard'],function(){
    Route::get('/',function () {return view('app');});
    Route::get('/userlist', function () {return view('app');});
    Route::get('/baranglist', function () {return view('app');});
    Route::get('/articleslist', function () {return view('app');});
    Route::get('/articlespost/{detail}/{id}', function () {return view('app');});
});