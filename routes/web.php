<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
Route::get('/password-reset/{token}', ResetPassword::class)->name('password.reset');

Route::get('/dashboard', function () {
    return '<h1>Dashboard - En construction</h1>';
})->name('dashboard');
