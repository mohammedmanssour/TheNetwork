<?php

$middleware = [];
if(!app()->environment('testing')){
    $middleware[] = 'auth:api';
}

Route::apiResource('posts/{post}/likes', 'PostsLikesController',[
    'only' => ['index', 'store', 'destroy']
]);
Route::apiResource('posts/{post}/comments', 'CommentsController');
Route::apiResource('posts','PostsController')->middleware($middleware);