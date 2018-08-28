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

Route::get('/', function(){
    return response()->json(['message' => 'Laravel API', 'status' => 'Connected']);
});

Route::group(['namespace' => 'API'], function(){

    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');

    //Route::group(['middleware' => 'auth:api'], function(){

        Route::resource('users', 'UserController')->except(['create', 'edit']);
        Route::resource('posts', 'PostController')->except(['create', 'edit']);
        Route::resource('comments', 'CommentController')->except(['create', 'edit']);

        Route::get('/post/{id}/comments', 'PostController@showComments');

    //});

});
