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
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services',     [ServiceController::class, 'index'])->name('services');
Route::get('/how-it-works', fn() => view('pages.how-it-works'))->name('how-it-works');
Route::get('/contact',  [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::post('/testimonials', [\App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonials.store')->middleware('auth');
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
    Route::get('/book',        [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book',       [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');

    Route::get('/profile',          [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile',         [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password',[UserProfileController::class, 'changePassword'])->name('profile.password');

    Route::get('/messages',               [MessageController::class, 'userIndex'])->name('messages.index');
    Route::get('/messages/{proId}',       [MessageController::class, 'userChat'])->name('messages.chat');
    Route::post('/messages/{convId}/send',[MessageController::class, 'userSend'])->name('messages.send');
});

// ── PROFESSIONAL AUTH ────────────────────────────────
Route::get('/pro/login',           [ProAuthController::class, 'showLogin'])->name('pro.login');
Route::post('/pro/login',          [ProAuthController::class, 'login']);
Route::post('/pro/logout',         [ProAuthController::class, 'logout'])->name('pro.logout');
Route::get('/pro/change-password', [ProAuthController::class, 'showChangePassword'])->name('pro.change-password');
Route::post('/pro/change-password',[ProAuthController::class, 'changePassword']);

// ── PROFESSIONAL DASHBOARD ───────────────────────────
Route::get('/pro/dashboard',              [ProDashboardController::class, 'dashboard'])->name('pro.dashboard');
Route::get('/pro/bookings',               [ProDashboardController::class, 'bookings'])->name('pro.bookings');
Route::post('/pro/bookings/{id}',         [ProDashboardController::class, 'updateBooking'])->name('pro.bookings.update');
Route::get('/pro/profile',                [ProDashboardController::class, 'profile'])->name('pro.profile');
Route::post('/pro/profile',               [ProDashboardController::class, 'updateProfile'])->name('pro.profile.update');
Route::post('/pro/profile/password',      [ProDashboardController::class, 'changePassword'])->name('pro.profile.password');
Route::get('/pro/messages',               [MessageController::class, 'proIndex'])->name('pro.messages');
Route::get('/pro/messages/{convId}',      [MessageController::class, 'proChat'])->name('pro.messages.chat');
Route::post('/pro/messages/{convId}/send',[MessageController::class, 'proSend'])->name('pro.messages.send');

// ── SUPERADMIN (Professionals) ─────────────────────
Route::get('/superadmin',        fn() => redirect('/superadmin/login'));
Route::get('/superadmin/login',  function () {
    if (session('pro_id')) return redirect('/pro/dashboard');
    return view('superadmin.login');
})->name('superadmin.login');
Route::post('/superadmin/login', [ProAuthController::class, 'login'])->name('superadmin.login.post');

// ── ADMIN ────────────────────────────────────────────
Route::get('/admin',                             fn() => redirect('/admin/dashboard'));
Route::get('/admin/login',                       [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',                      [AdminController::class, 'login']);
Route::post('/admin/logout',                     [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard',                   [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/bookings',                    [AdminController::class, 'bookings'])->name('admin.bookings');
Route::post('/admin/bookings/{id}',              [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
Route::get('/admin/users',                       [AdminController::class, 'users'])->name('admin.users');
Route::delete('/admin/users/{id}',               [AdminController::class, 'deleteUser'])->name('admin.users.delete');
Route::get('/admin/professionals',               [AdminController::class, 'professionals'])->name('admin.professionals');
Route::post('/admin/professionals',              [AdminController::class, 'storeProfessional'])->name('admin.professionals.store');
Route::post('/admin/professionals/{id}',         [AdminController::class, 'updateProfessional'])->name('admin.professionals.update');
Route::post('/admin/professionals/{id}/reset',   [AdminController::class, 'resetProPassword'])->name('admin.professionals.reset');
Route::post('/admin/professionals/{id}/toggle',  [AdminController::class, 'toggleProActive'])->name('admin.professionals.toggle');
Route::delete('/admin/professionals/{id}',       [AdminController::class, 'deleteProfessional'])->name('admin.professionals.delete');
Route::get('/admin/testimonials',                [AdminController::class, 'testimonials'])->name('admin.testimonials');
Route::post('/admin/testimonials/{id}/approve',  [AdminController::class, 'approveTestimonial'])->name('admin.testimonials.approve');
Route::delete('/admin/testimonials/{id}',        [AdminController::class, 'deleteTestimonial'])->name('admin.testimonials.delete');
Route::get('/admin/messages',                    [AdminController::class, 'messages'])->name('admin.messages');
Route::get('/admin/contact-messages',            [AdminController::class, 'contactMessages'])->name('admin.contact-messages');
Route::post('/admin/contact-messages/{id}/read', [AdminController::class, 'markContactRead'])->name('admin.contact-messages.read');
Route::delete('/admin/contact-messages/{id}',   [AdminController::class, 'deleteContact'])->name('admin.contact-messages.delete');

// ── TEMP SEED (delete after use) ──────────────────────
Route::get('/run-seed-hf2026', function () {
    if (request('key') !== 'homefix-seed-2026') abort(403);
    try {
        \Artisan::call('db:seed', ['--force' => true]);
        return 'Seeded OK: ' . \Artisan::output();
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/check-pros-hf2026', function () {
    if (request('key') !== 'homefix-seed-2026') abort(403);
    return \App\Models\Professional::select('id','first_name','email','password','is_verified','is_active')->get();
});

// ── TEMPORARY MIGRATION ROUTE (for Vercel) ─────────────
Route::get('/run-migration', function () {
    if (request('key') !== 'homefix-migrate-2026') {
        abort(403, 'Invalid key');
    }
    try {
        \Artisan::call('migrate', ['--force' => true]);
        return '✅ Migrations ran successfully!<br><pre>' . \Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});