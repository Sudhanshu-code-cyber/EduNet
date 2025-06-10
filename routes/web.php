<?php

use Illuminate\Support\Facades\Route;

Route::get('/student/dashboard', function () {
    return view('page/student/dashboard');
});



