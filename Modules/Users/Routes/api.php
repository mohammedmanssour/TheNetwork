<?php

Route::post('register', 'RegistrationController@store');
Route::post('login', 'LoginController@index');

$middleware = [];
if(!app()->environment('testing')){
    $middleware[] = 'auth:api';
}
Route::middleware($middleware)->group(function(){
    get('me', 'UserController@show');
});