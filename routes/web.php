<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Professionals
Route::get('/pros/{id}', [ProfessionalController::class, 'show'])->name('pro.show');

// Booking
Route::get('/book',        [BookingController::class, 'create'])->name('booking.create')->middleware('auth');
Route::post('/book',       [BookingController::class, 'store'])->name('booking.store')->middleware('auth');
Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index')->middleware('auth');

// Services / Info
Route::get('/services',     [ServiceController::class, 'index'])->name('services');
Route::get('/how-it-works', fn() => view('pages.how-it-works'))->name('how-it-works');
Route::get('/contact',      fn() => view('pages.contact'))->name('contact');