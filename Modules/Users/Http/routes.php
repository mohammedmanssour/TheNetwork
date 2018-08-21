<?php

Route::middleware('api')
    ->prefix('api')
    ->namespace('Modules\Users\Http\Controllers')
    ->group(module_path('Users').'/Routes/api.php');
