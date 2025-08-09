<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentPaymentController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
    
    // Property Routes
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    
    // Property Image Management Routes
    Route::delete('/properties/images/{image}', [PropertyController::class, 'deleteImage'])->name('properties.images.delete');
    Route::post('/properties/images/{image}/set-main', [PropertyController::class, 'setMainImage'])->name('properties.images.set-main');
    
    // Payment Routes
    Route::prefix('payments')->group(function () {

    Route::get('/', [RentPaymentController::class, 'index'])->name('rent-payments.index');
    Route::get('/create', [RentPaymentController::class, 'create'])->name('rent-payments.create');
    Route::post('/', [RentPaymentController::class, 'store'])->name('rent-payments.store');
    Route::get('/{rentPayment}', [RentPaymentController::class, 'show'])->name('rent-payments.show');
    Route::get('/{rentPayment}/edit', [RentPaymentController::class, 'edit'])->name('rent-payments.edit');
    Route::put('/{rentPayment}', [RentPaymentController::class, 'update'])->name('rent-payments.update');
    Route::delete('/{rentPayment}', [RentPaymentController::class, 'destroy'])->name('rent-payments.destroy');
    
    Route::post('/{rentPayment}/mark-paid', [RentPaymentController::class, 'markAsPaid'])->name('rent-payments.mark-paid');
    Route::post('/generate-monthly', [RentPaymentController::class, 'generateMonthlyPayments'])->name('rent-payments.generate');
    Route::get('/property/{propertyId}/tenant', [RentPaymentController::class, 'getPropertyTenant'])->name('rent-payments.property-tenant');
    
    });

    Route::prefix('rent-payments')->group(function () {
    Route::get('/', [RentPaymentController::class, 'index'])->name('rent-payments.index');
    Route::get('/property/{propertyId}', [RentPaymentController::class, 'propertyPayments'])->name('rent-payments.property');
    Route::post('/{rentPayment}/mark-paid', [RentPaymentController::class, 'markAsPaid'])->name('rent-payments.mark-paid');
    Route::post('/generate-monthly', [RentPaymentController::class, 'generateMonthlyPayments'])->name('rent-payments.generate');
});
});