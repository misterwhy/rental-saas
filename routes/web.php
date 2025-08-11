<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentPaymentController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\SettingsController; // Don't forget to import the SettingsController

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tenant Routes
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'tenantDashboard'])->name('dashboard');

    // Property Routes for Tenants
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    // Rent Payment Routes for Tenants
    Route::get('/rent-payments', [RentPaymentController::class, 'index'])->name('rent-payments.index');
    Route::get('/rent-payments/create', [RentPaymentController::class, 'create'])->name('rent-payments.create');
    Route::post('/rent-payments', [RentPaymentController::class, 'store'])->name('rent-payments.store');
    Route::get('/rent-payments/{rentPayment}', [RentPaymentController::class, 'show'])->name('rent-payments.show');
    Route::get('/rent-payments/{rentPayment}/edit', [RentPaymentController::class, 'edit'])->name('rent-payments.edit');
    Route::put('/rent-payments/{rentPayment}', [RentPaymentController::class, 'update'])->name('rent-payments.update');
    Route::delete('/rent-payments/{rentPayment}', [RentPaymentController::class, 'destroy'])->name('rent-payments.destroy');
    Route::get('/rent-payments/{rentPayment}/pdf', [RentPaymentController::class, 'downloadPDF'])->name('rent-payments.pdf');
    Route::post('/rent-payments/{rentPayment}/mark-paid', [RentPaymentController::class, 'markAsPaid'])->name('rent-payments.mark-paid');
    Route::get('/rent-payments/property/{propertyId}/tenant', [RentPaymentController::class, 'getPropertyTenant'])->name('rent-payments.property-tenant');

    // Profile Management for Tenants
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
    
    // Settings Routes for Tenants
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences.update');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
});

// Landlord Routes
Route::middleware(['auth', 'role:landlord'])->prefix('landlord')->name('landlord.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'landlordDashboard'])->name('dashboard');

    // Analytics for Landlords
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Property Routes for Landlords
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

    // Rent Payment Routes for Landlords
    Route::get('/rent-payments', [RentPaymentController::class, 'index'])->name('rent-payments.index');
    Route::get('/rent-payments/create', [RentPaymentController::class, 'create'])->name('rent-payments.create');
    Route::post('/rent-payments', [RentPaymentController::class, 'store'])->name('rent-payments.store');
    Route::get('/rent-payments/{rentPayment}', [RentPaymentController::class, 'show'])->name('rent-payments.show');
    Route::get('/rent-payments/{rentPayment}/edit', [RentPaymentController::class, 'edit'])->name('rent-payments.edit');
    Route::put('/rent-payments/{rentPayment}', [RentPaymentController::class, 'update'])->name('rent-payments.update');
    Route::delete('/rent-payments/{rentPayment}', [RentPaymentController::class, 'destroy'])->name('rent-payments.destroy');
    Route::get('/rent-payments/{rentPayment}/pdf', [RentPaymentController::class, 'downloadPDF'])->name('rent-payments.pdf');
    Route::post('/rent-payments/{rentPayment}/mark-paid', [RentPaymentController::class, 'markAsPaid'])->name('rent-payments.mark-paid');
    Route::post('/rent-payments/generate-monthly', [RentPaymentController::class, 'generateMonthlyPayments'])->name('rent-payments.generate');
    Route::get('/rent-payments/property/{propertyId}/tenant', [RentPaymentController::class, 'getPropertyTenant'])->name('rent-payments.property-tenant');

    // Profile Management for Landlords
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');

    // Settings Routes for Landlords
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences.update');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::put('/settings/landlord', [SettingsController::class, 'updateLandlordSettings'])->name('settings.landlord.update');
});

// Main Dashboard Route (for backward compatibility)
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');