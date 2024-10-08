<?php

use App\Http\Controllers\Gateways\GatewayController;
use App\Http\Controllers\Gateways\NagadPaymentGatewayController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);

    Route::group(['prefix' => '{product}/gateways', 'as' => 'gateways.'], function () {
        Route::get('/', [GatewayController::class, 'index'])->name('index');
        Route::get('/payment-accounts', [GatewayController::class, 'paymentAccounts'])
            ->name('payment-accounts');
        Route::get('/process', [GatewayController::class, 'process'])->name('process');
        Route::get('/verify', [GatewayController::class, 'verify'])->name('verify');
    });
    Route::get('/gateways/cancel-authorization', [GatewayController::class, 'cancelAuthorization'])
        ->name('gateways.cancel-authorization');

    // call back for nagad
    Route::get('/gateways/nagad/callback', [NagadPaymentGatewayController::class, 'callback'])
        ->name('gateways.nagad.callback');
});

require __DIR__.'/auth.php';
