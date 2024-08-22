<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//Route::middleware('auth')->group(function(){
    Route::post("/fetch_user_api",[UserController::class, 'login_user']);
    Route::post("/register_user_api",[UserController::class, 'register_user']);
    Route::post("/upload_documents",[UserController::class, 'upload_documents']);
    Route::post("/support",[UserController::class, 'fetch_support_data']);
    Route::post("/change_pin",[UserController::class, 'change_user_pin']);
    Route::post("/fetch_user_files",[UserController::class, 'fetch_user_files']);
//});

Route::prefix("User")->group(function(){
    Route::get("/add_user_home",[UserController::class, 'add_user_index'])->name("user.index");
    Route::get("/user_accounts",[UserController::class, 'user_accounts_index'])->name("user.accounts.index");
    Route::post("/add_user_account",[UserController::class, 'add_user'])->name("user.add.account");
});