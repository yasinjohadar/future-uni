<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/portal', '/student');
Route::redirect('/portal/login', '/login');
Route::any('/portal/{any}', fn () => redirect('/student'))
    ->where('any', '.*');
