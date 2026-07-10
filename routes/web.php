<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\SuperAdmin\RestaurantController as SuperAdminRestaurantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\PublicMenuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/menu/{slug}', [PublicMenuController::class, 'show'])->name('menu.show');
Route::get('/menu/{slug}/search', [PublicMenuController::class, 'search'])->name('menu.search');
Route::post('/menu/{slug}/item/{itemId}/view', [PublicMenuController::class, 'trackView'])->name('menu.item.view');
Route::get('/menu/{slug}/item/{itemId}/recommendations', [PublicMenuController::class, 'recommendations'])->name('menu.item.recommendations');

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/restaurant', [AdminRestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::post('/restaurant', [AdminRestaurantController::class, 'update'])->name('restaurant.update');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/items', [ItemController::class, 'index'])->name('items.index');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
    });

    Route::middleware('role:super_admin')->prefix('super-admin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/restaurants', [SuperAdminRestaurantController::class, 'index'])->name('restaurants');
        Route::post('/restaurants/{id}/toggle', [SuperAdminRestaurantController::class, 'toggleActive'])->name('restaurants.toggle');
    });

});