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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('Localization')->group(function () {

Route::middleware('auth:api')->group(function () {
    Route::middleware('adminAuth')->group(function () {
        Route::get('/adminuser', 'AdminController@loggedInUser');
    });
    Route::get('chechAuth', function(){
        echo json_encode('Yes hitted');
    });
    Route::middleware('userAuth')->group(function () {
        Route::get('/user', 'UserController@loggedInUser');
    });
    Route::post('/resetPassword', 'UserController@resetPassword');
    Route::post('/refreshToken', 'UserController@refreshToken');
    Route::post('/logout','UserController@logout');
    
});
Route::prefix('authenticate')->group(function () {
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
});

 

Route::get('/testLang', function()
{
    echo __("handler")['auth_exception'];//__("handler")['validation_exception'];//__('welcome');
});

});//Localization