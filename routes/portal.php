<?php

use App\Http\Controllers\Frontend\Portal\PortalAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('portal')->name('portal.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [PortalAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [PortalAuthController::class, 'login'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', [PortalAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [PortalAuthController::class, 'logout'])->name('logout');
    });
});
