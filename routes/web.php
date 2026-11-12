<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

// Home Page (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Page (Public - No login required)
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Guest Routes (No login required)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes (Login required)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Product Routes - All users can view, only Admin + Accountant can create/edit/delete
    Route::resource('products', ProductController::class)->middleware('auth');
    
    // Customer Routes (All users can manage)
    Route::resource('customers', CustomerController::class);
    
    // Supplier Routes (Admin + Accountant only)
    Route::resource('suppliers', SupplierController::class)->middleware('role:admin,accountant');
    
    // Invoice Routes (Admin + Accountant only - Sales Staff cannot create)
    Route::resource('invoices', InvoiceController::class)->middleware('role:admin,accountant');
    
    // Expense Routes (Admin + Accountant only)
    Route::resource('expenses', ExpenseController::class)->middleware('role:admin,accountant');

    // Reports Routes (Admin + Accountant only)
    Route::middleware(['role:admin,accountant'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/daily-sales', [ReportController::class, 'dailySales'])->name('reports.daily-sales');
        Route::get('/reports/monthly-sales', [ReportController::class, 'monthlySales'])->name('reports.monthly-sales');
        Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        Route::get('/reports/expenses', [ReportController::class, 'expenseReport'])->name('reports.expenses');
        Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    });
});