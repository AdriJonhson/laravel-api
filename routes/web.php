<?php

Route::group(['prefix' => 'api'], function(){

    Route::get('/', function(){
        return response()->json(['message' => 'Laravel API', 'status' => 'Connected']);
    });

    Route::resource('users', 'UserController');
    Route::resource('posts', 'PostController');
    Route::resource('comments', 'CommentController');
});

Route::get('/', function () {
    return redirect('api');
});
