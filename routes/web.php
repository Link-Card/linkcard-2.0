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
use App\Livewire\Profile\Index;
use App\Livewire\Profile\Create;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
Route::get('/password-reset/{token}', ResetPassword::class)->name('password.reset');

Route::get('/email/verify', VerifyEmailNotice::class)->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Home::class)->name('dashboard');
    
    // Routes Profils
    Route::get('/dashboard/profiles', Index::class)->name('profile.index');
    Route::get('/dashboard/profiles/create', Create::class)->name('profile.create');
    Route::get('/dashboard/profiles/{profile}/edit', function() {
        return 'Édition disponible en Sprint 2.5 (prochaine étape)';
    })->name('profile.edit');
    
    // Routes pricing et additionnels (temporaires)
    Route::get('/pricing', function() {
        return 'Page pricing - Sprint 3';
    })->name('pricing');
    
    Route::get('/dashboard/profiles/add-additional', function() {
        return 'Acheter profils additionnels - Sprint 2.6';
    })->name('profile.add-additional');
    
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// Route publique - Affichage profil (DOIT être en dernier pour éviter conflits)
Route::get('/{username}', [ProfileController::class, 'show'])->name('profile.public');
