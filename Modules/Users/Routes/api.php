<?php

Route::post('register', 'RegistrationController@store');
Route::post('login', 'LoginController@index');

$middleware = [];
if(!app()->environment('testing')){
    $middleware[] = 'auth:api';
}
Route::middleware($middleware)->group(function(){
    Route::apiResource('users/{user}/followers', 'FollowersController',[
        'only' => ['index', 'store']
    ]);
    Route::delete('users/{user}/followers','FollowersController@destroy');

    Route::get('users/{user}/following', 'FollowingController@index');
    Route::get('me', 'UserController@show');
    Route::put('me', 'UserController@update');
});