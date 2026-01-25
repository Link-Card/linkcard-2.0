<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', Register::class)->name('register');

Route::get('/dashboard', function () {
    return '<h1>Dashboard - En construction</h1>';
})->name('dashboard');
