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

Route::get('/', 'IndexController');

Auth::routes([
    'register' => true,
    'reset' => false,
    'verify' => false,
]);

Route::get('/logout', 'Auth\LoginController@showLogout');

Route::get('email/verify', 'Auth\Email\VerifyNoticeAction')->name('verification.notice');
Route::get('email/verify/{type}/{user}', 'Auth\Email\VerifyAction')->name('verification.verify');
Route::post('email/resend', 'Auth\Email\ResendAction')->name('verification.resend');

Route::middleware(['auth', 'verified'])->group(function () {
    // ログインされており、メールアドレス認証が済んでいる場合のみアクセス可能なルートはここへ
    Route::get('/home', 'HomeController@index')->name('home');
});
