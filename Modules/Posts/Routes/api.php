<?php

$middleware = [];
if(!app()->environment('testing')){
    $middleware[] = 'auth:api';
}

Route::delete('posts/{post}/likes','PostsLikesController@destroy')->middleware($middleware);
Route::apiResource('posts/{post}/likes', 'PostsLikesController',[
    'only' => ['index', 'store']
])->middleware($middleware);
Route::apiResource('posts/{post}/comments', 'CommentsController');
Route::apiResource('posts','PostsController')->middleware($middleware);