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
use App\Http\Controllers\Admin\TableRequestController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\UserController;

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
Route::post('/menu/{slug}/item/{itemId}/notify', [PublicMenuController::class, 'notifyWaiter'])->name('menu.item.notify');

Route::middleware('auth')->group(function () {

    Route::post('/stop-impersonating', [UserController::class, 'stopImpersonating'])->name('stop-impersonating');
    
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

        Route::get('/table-requests', [TableRequestController::class, 'index'])->name('table-requests.index');
        Route::post('/table-requests/{id}/acknowledge', [TableRequestController::class, 'acknowledge'])->name('table-requests.acknowledge');    

        Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
        Route::get('/bills/table/{tableNumber}', [BillController::class, 'show'])->name('bills.show');
        Route::post('/bills/{billId}/add-item', [BillController::class, 'addItem'])->name('bills.add-item');
        Route::delete('/bills/{billId}/remove-item/{itemId}', [BillController::class, 'removeItem'])->name('bills.remove-item');
        Route::put('/bills/{billId}/update-quantity/{itemId}', [BillController::class, 'updateQuantity'])->name('bills.update-quantity');
        Route::post('/bills/{billId}/mark-paid', [BillController::class, 'markPaid'])->name('bills.mark-paid');
        Route::get('/bills/history', [BillController::class, 'history'])->name('bills.history');
        Route::post('/bills/{billId}/reopen', [BillController::class, 'reopen'])->name('bills.reopen');
    });

    Route::middleware('role:super_admin')->prefix('super-admin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/restaurants', [SuperAdminRestaurantController::class, 'index'])->name('restaurants');
        Route::get('/restaurants/{id}', [SuperAdminRestaurantController::class, 'show'])->name('restaurants.show');
        Route::post('/restaurants/{id}/toggle', [SuperAdminRestaurantController::class, 'toggleActive'])->name('restaurants.toggle');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
        Route::get('/plans', [PlanController::class, 'index'])->name('plans');
        Route::put('/plans/{id}', [PlanController::class, 'update'])->name('plans.update');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/users/{id}/toggle-ban', [UserController::class, 'toggleBan'])->name('users.toggle-ban');
        Route::post('/users/{id}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
    });

});