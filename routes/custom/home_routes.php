<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

//Route::middleware('auth')->group(function(){
    Route::get("/",[HomeController::class, 'home_index'])->name('home.home');
//});