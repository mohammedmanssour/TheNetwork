<?php
$middleware = ['api'];
if(!app()->environment('testing')){
    $middleware[] = 'auth:api';
}

Route::prefix('api')
    ->middleware($middleware)
    ->namespace('Modules\Files\Http\Controllers')
    ->group(function(){
        Route::post('files/upload', 'FilesController@store');
        Route::get('files/{media}', 'FilesController@show');
    });