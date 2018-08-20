<?php

Route::post('register', 'RegistrationController@store');
Route::post('login', 'LoginController@index');

Route::middleware('auth:api')->get('me', 'UserController@show');