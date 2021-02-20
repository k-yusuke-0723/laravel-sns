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

Auth::routes();
// Routeファサードにnameメソッドを繋げるとそのルーティングに名前が付けられる
Route::get('/', 'ArticleController@index')->name('articles.index');
// showアクションメソッドに対してauthミドルウェアを使わない
Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
Route::resource('/articles', 'ArticleController')->only(['show']);

// groupメソッドを使用
Route::prefix('articles')->name('articles.')->group(function() {
    Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
    Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});

// タグ毎の一覧画面作成するルーティング設定
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');

Route::prefix('users')->name('users.')->group(function() {
    Route::get('/{name}', 'UserController@show')->name('show');
});
