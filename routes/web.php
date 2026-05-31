<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services',     [ServiceController::class, 'index'])->name('services');
Route::get('/how-it-works', fn() => view('pages.how-it-works'))->name('how-it-works');
Route::get('/contact',      fn() => view('pages.contact'))->name('contact');
Route::get('/pros/{id}',    [ProfessionalController::class, 'show'])->name('pro.show');

// Auth
Route::get('/login',        [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',       [AuthController::class, 'login']);
Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register']);
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-code',  [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify-code', [AuthController::class, 'verify'])->name('verify.submit');
Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('verify.resend');

// Booking (auth required)
Route::get('/book',         [BookingController::class, 'create'])->name('booking.create')->middleware('auth');
Route::post('/book',        [BookingController::class, 'store'])->name('booking.store')->middleware('auth');
Route::get('/my-bookings',  [BookingController::class, 'index'])->name('booking.index')->middleware('auth');

// Admin
Route::get('/admin',                    fn() => redirect('/admin/dashboard'));
Route::get('/admin/login',              [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',             [AdminController::class, 'login']);
Route::post('/admin/logout',            [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard',          [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/bookings',           [AdminController::class, 'bookings'])->name('admin.bookings');
Route::post('/admin/bookings/{id}',     [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
Route::get('/admin/users',              [AdminController::class, 'users'])->name('admin.users');
Route::delete('/admin/users/{id}',      [AdminController::class, 'deleteUser'])->name('admin.users.delete');
Route::get('/admin/professionals',      [AdminController::class, 'professionals'])->name('admin.professionals');
Route::post('/admin/professionals',     [AdminController::class, 'storeProfessional'])->name('admin.professionals.store');
Route::post('/admin/professionals/{id}',[AdminController::class, 'updateProfessional'])->name('admin.professionals.update');
Route::delete('/admin/professionals/{id}',[AdminController::class, 'deleteProfessional'])->name('admin.professionals.delete');
Route::get('/admin/testimonials',       [AdminController::class, 'testimonials'])->name('admin.testimonials');
Route::post('/admin/testimonials/{id}/approve', [AdminController::class, 'approveTestimonial'])->name('admin.testimonials.approve');
Route::delete('/admin/testimonials/{id}',       [AdminController::class, 'deleteTestimonial'])->name('admin.testimonials.delete');