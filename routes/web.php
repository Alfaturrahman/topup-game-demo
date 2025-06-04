<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\TripayController;

Route::get('/topup', [TopupController::class, 'showForm'])->name('topup.form');
Route::post('/topup', [TopupController::class, 'store']);

// Tripay callback
Route::post('/callback-tripay', [TripayController::class, 'handleCallback'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Admin routes (sementara tanpa auth middleware)
Route::prefix('admin')->group(function () {
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::post('/admin/products/discount', [AdminController::class, 'applyBulkDiscount'])->name('admin.products.discount');
    Route::patch('admin/products/{id}/remove-discount', [AdminController::class, 'removeDiscount'])->name('admin.products.removeDiscount');


    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/income', [AdminController::class, 'income'])->name('admin.income');

    Route::post('/orders/{transaction}/upload-bukti', [AdminController::class, 'uploadBukti'])->name('admin.orders.uploadBukti');

});
