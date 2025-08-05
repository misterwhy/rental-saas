<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes
// --- MOVE THE CREATE ROUTE HERE ---
Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
// --- END MOVED ROUTE ---
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Property Image Management Routes (outside auth group for GET requests)
// Note: These might need adjustment depending on who can delete/set main images.
Route::delete('/properties/images/{image}', [PropertyController::class, 'deleteImage'])->name('properties.images.delete');
Route::post('/properties/images/{image}/set-main', [PropertyController::class, 'setMainImage'])->name('properties.images.set-main');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Property CRUD Routes (POST, PUT, DELETE still protected)
    // Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create'); // <- REMOVE THIS LINE
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::resource('properties', PropertyController::class);
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
});