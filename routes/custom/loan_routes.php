<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::post("/fetch_user_loan_data",[LoanController::class, 'get_user_loan_details']);
Route::post("/pay_loan",[LoanController::class, 'pay_loan']);
Route::post("/request_loan",[LoanController::class, 'request_loan']);