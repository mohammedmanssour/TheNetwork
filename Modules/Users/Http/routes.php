<?php

Route::middleware('api')
    ->prefix('api')
    ->group(module_path('Users').'/Routes/api.php');
