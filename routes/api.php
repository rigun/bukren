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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('refresh', 'AuthController@refresh');
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('/user/list', 'UserController@index');
    Route::get('/user/detail/', 'UserDetailController@index');
    Route::post('/user/detail/', 'UserDetailController@store');
    Route::get('/penerima/detail/{token}', 'UserDetailController@showByChatToken');

    Route::post('/slider', 'SliderController@store');
    Route::delete('/slider/{id}', 'SliderController@destroy');

    Route::post('/kategori', 'KategoriController@store');
    Route::patch('/kategori/{id}', 'KategoriController@update');
    Route::delete('/kategori/{id}', 'KategoriController@destroy');

    Route::post('/barang', 'BookController@store');
    Route::post('/barang/{id}', 'BookController@update');
    Route::delete('/barang/{id}', 'BookController@destroy');
    Route::get('/barang/unique', 'BookController@apiCheckUnique');
    
    Route::get('/bag', 'BagController@index');
    Route::post('/bag', 'BagController@store');
    Route::get('/bag/count', 'BagController@count');
    Route::delete('/bag/{id}', 'BagController@destroy');
    
    Route::get('/pesan', 'ChatController@index');
    Route::post('/outbox', 'ListChatController@store');
    Route::get('/inbox/{token}', 'ListChatController@show');
    Route::post('/pesan', 'ChatController@store');
    Route::get('/pesan/count', 'ChatController@count');
    Route::delete('/pesan/{id}', 'ChatController@destroy');

    Route::get('/barang', 'BookController@index');
    Route::get('/barang/all', 'BookController@showAll');

    Route::get('/article/{id}', 'ArticleController@show');
    Route::post('/article', 'ArticleController@store');
    Route::patch('/article/{id}', 'ArticleController@updateStatus');
    Route::delete('/article/{id}', 'ArticleController@destroy');
    Route::post('/article/{id}', 'ArticleController@update');

});
Route::get('/slider', 'SliderController@index');
Route::get('/article', 'ArticleController@index');
Route::get('/blog/{slug}', 'ArticleController@showBySlug');
Route::get('/barangdetail/{slug}', 'BookController@detailBarang');
Route::get('/barang/terbaru', 'BookController@newItem');
Route::get('/barang/rekomendasi', 'BookController@recomendedItem');
Route::get('/barang/gratis', 'BookController@freeItem');
Route::get('/barang/berbayar', 'BookController@paidItem');
Route::get('/barang/{kategori}', 'BookController@show');
Route::get('/barangType/{type}', 'BookController@showByType');
Route::get('/search/{search}', 'BookController@search');
Route::get('/kategori', 'KategoriController@index');
Route::post('/user', 'AuthController@register');
Route::get('/user/email/{email}', 'UserController@apiCheckUnique');
Route::post('/mail/send', 'MailController@send');
Route::get('/user/verfikasi/{token}', 'UserController@verifikasi');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});