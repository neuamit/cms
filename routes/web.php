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
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

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

    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')->name('verification.send');

    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscription/failure', [SubscriptionController::class, 'failure'])->name('subscription.failure');

    Route::middleware(['role:admin', 'verified'])->prefix('admin')->name('admin.')->group(function () {
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

        Route::get('/subscription', [SubscriptionController::class, 'show'])->name('subscription.show');
        Route::post('/subscription/claim-trial', [SubscriptionController::class, 'claimTrial'])->name('subscription.claim-trial');
        Route::post('/subscription/initiate', [SubscriptionController::class, 'initiate'])->name('subscription.initiate');
    });

    Route::middleware('role:super_admin')->prefix('super-admin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/restaurants', [SuperAdminRestaurantController::class, 'index'])->name('restaurants');
        Route::get('/restaurants/{id}', [SuperAdminRestaurantController::class, 'show'])->name('restaurants.show');
        Route::post('/restaurants/{id}/toggle', [SuperAdminRestaurantController::class, 'toggleActive'])->name('restaurants.toggle');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    });

});