<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TopupController;
use App\Http\Controllers\TripayController;

Route::get('/topup', [TopupController::class, 'showForm'])->name('topup.form');
Route::post('/topup', [TopupController::class, 'store']);

//Triplay
Route::post('/callback-tripay', [TripayController::class, 'handleCallback'])
    ->withoutMiddleware('csrf');



