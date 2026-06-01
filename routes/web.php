<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProAuthController;
use App\Http\Controllers\ProDashboardController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services',     [ServiceController::class, 'index'])->name('services');
Route::get('/how-it-works', fn() => view('pages.how-it-works'))->name('how-it-works');
Route::get('/pros/{id}',    [ProfessionalController::class, 'show'])->name('pro.show');

// ── USER AUTH ────────────────────────────────────────
Route::get('/login',        [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',       [AuthController::class, 'login']);
Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register']);
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-code',  [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify-code', [AuthController::class, 'verify'])->name('verify.submit');
Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('verify.resend');

// ── USER FEATURES (auth required) ───────────────────
Route::middleware('auth')->group(function () {
    Route::get('/book',         [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book',        [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings',  [BookingController::class, 'index'])->name('booking.index');
    Route::get('/messages',              [MessageController::class, 'userIndex'])->name('messages.index');
    Route::get('/messages/{proId}',      [MessageController::class, 'userChat'])->name('messages.chat');
    Route::post('/messages/{convId}/send',[MessageController::class, 'userSend'])->name('messages.send');
});

// ── PROFESSIONAL AUTH ────────────────────────────────
Route::get('/pro/login',    [ProAuthController::class, 'showLogin'])->name('pro.login');
Route::post('/pro/login',   [ProAuthController::class, 'login']);
Route::get('/pro/register', [ProAuthController::class, 'showRegister'])->name('pro.register');
Route::post('/pro/register',[ProAuthController::class, 'register']);
Route::post('/pro/logout',  [ProAuthController::class, 'logout'])->name('pro.logout');
Route::get('/pro/verify',   [ProAuthController::class, 'showVerify'])->name('pro.verify');
Route::post('/pro/verify',  [ProAuthController::class, 'verify']);
Route::post('/pro/resend',  [ProAuthController::class, 'resendCode'])->name('pro.resend');

// ── PROFESSIONAL DASHBOARD ───────────────────────────
Route::get('/pro/dashboard',         [ProDashboardController::class, 'dashboard'])->name('pro.dashboard');
Route::get('/pro/bookings',          [ProDashboardController::class, 'bookings'])->name('pro.bookings');
Route::post('/pro/bookings/{id}',    [ProDashboardController::class, 'updateBooking'])->name('pro.bookings.update');
Route::get('/pro/profile',           [ProDashboardController::class, 'profile'])->name('pro.profile');
Route::post('/pro/profile',          [ProDashboardController::class, 'updateProfile'])->name('pro.profile.update');
Route::get('/pro/messages',          [MessageController::class, 'proIndex'])->name('pro.messages');
Route::get('/pro/messages/{convId}', [MessageController::class, 'proChat'])->name('pro.messages.chat');
Route::post('/pro/messages/{convId}/send', [MessageController::class, 'proSend'])->name('pro.messages.send');

// ── ADMIN ────────────────────────────────────────────
Route::get('/admin',                         fn() => redirect('/admin/dashboard'));
Route::get('/admin/login',                   [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',                  [AdminController::class, 'login']);
Route::post('/admin/logout',                 [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard',               [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/bookings',                [AdminController::class, 'bookings'])->name('admin.bookings');
Route::post('/admin/bookings/{id}',          [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
Route::get('/admin/users',                   [AdminController::class, 'users'])->name('admin.users');
Route::delete('/admin/users/{id}',           [AdminController::class, 'deleteUser'])->name('admin.users.delete');
Route::get('/admin/professionals',           [AdminController::class, 'professionals'])->name('admin.professionals');
Route::post('/admin/professionals',          [AdminController::class, 'storeProfessional'])->name('admin.professionals.store');
Route::post('/admin/professionals/{id}',     [AdminController::class, 'updateProfessional'])->name('admin.professionals.update');
Route::delete('/admin/professionals/{id}',   [AdminController::class, 'deleteProfessional'])->name('admin.professionals.delete');
Route::get('/admin/testimonials',            [AdminController::class, 'testimonials'])->name('admin.testimonials');
Route::post('/admin/testimonials/{id}/approve', [AdminController::class, 'approveTestimonial'])->name('admin.testimonials.approve');
Route::delete('/admin/testimonials/{id}',    [AdminController::class, 'deleteTestimonial'])->name('admin.testimonials.delete');
Route::get('/admin/messages',                [AdminController::class, 'messages'])->name('admin.messages');