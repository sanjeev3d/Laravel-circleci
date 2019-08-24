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
CONST defLang = 'en';
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'UserController@test');
Route::get('/eng/{lang?}', function($lang = defLang){
    //dump(env('APP_URL', 'g'));
    dump($_SERVER);
    App::setLocale($lang);
    return view('lang');
});

Route::get('/user/verify/{token}', 'UserController@verifyUser');
//Route::get('/test', 'UserController@test');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
