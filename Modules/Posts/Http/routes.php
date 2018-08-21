<?php

Route::prefix('api')
    ->middleware('api')
    ->namespace('Modules/Posts/Http/Controllers')
    ->group(module_path('Posts').'/Routes/api.php');
