<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DeliveryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('medicines', MedicineController::class);
    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::resource('sales', SaleController::class);
    Route::resource('deliveries', DeliveryController::class);
    
    Route::get('/reports/sales', [SaleController::class, 'reports'])->name('sales.reports');
    Route::get('/reports/inventory', [MedicineController::class, 'reports'])->name('medicines.reports');
});
