<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TopupController;

Route::get('/topup', [TopupController::class, 'showForm'])->name('topup.form');
Route::post('/topup', [TopupController::class, 'store']);


