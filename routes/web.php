<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmailNotice;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Dashboard\Home;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
Route::get('/password-reset/{token}', ResetPassword::class)->name('password.reset');

Route::get('/email/verify', VerifyEmailNotice::class)->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Home::class)->name('dashboard');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->middleware('auth')->name('logout');
