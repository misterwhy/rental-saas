<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HomeController;

// Define the home route
Route::get('/', function () {
    return redirect()->route('properties.index');
})->name('home');

// Or if you have a HomeController
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Properties routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Logout route
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');
});