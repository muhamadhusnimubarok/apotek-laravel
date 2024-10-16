<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;

Route::middleware(['isGuest'])->group(function(){
    // Route::get('/', function() {
    //     return view('user.login');})->name('login');
    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});
// Routes that require the user to be logged in
Route::middleware(['isLogin'])->group(function() {
    
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    
    Route::get('/home', function () {
        return view('pages.home');
    })->name('home.page');

Route::middleware(['isAdmin'])->group(function() {


    // Medicine routes
    Route::prefix('/medicine')->name('medicine.')->group(function() {
        Route::get('/create', [MedicineController::class, 'create'])->name('create');
        Route::post('/store', [MedicineController::class, 'store'])->name('store');
        Route::get('/index', [MedicineController::class, 'index'])->name('home');
        Route::get('/{id}', [MedicineController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [MedicineController::class, 'update'])->name('update');
        Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('delete');
        
        // Stock routes
        Route::get('/data/stock', [MedicineController::class, 'stock'])->name('stock');
        Route::get('/data/stock/{id}', [MedicineController::class, 'stockEdit'])->name('stock.edit');
        Route::patch('/data/stock/{id}', [MedicineController::class, 'stockUpdate'])->name('stock.update');
    });

    // Account routes
    Route::prefix('/account')->name('account.')->group(function() {
        Route::get('/', [AccountController::class, 'index'])->name('index'); 
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/store', [AccountController::class, 'store'])->name('store'); 
        Route::get('/{id}', [AccountController::class, 'edit'])->name('edit'); 
        Route::patch('/{id}', [AccountController::class, 'update'])->name('update'); 
        Route::delete('/{id}', [AccountController::class, 'destroy'])->name('destroy'); 
    });
});
});





