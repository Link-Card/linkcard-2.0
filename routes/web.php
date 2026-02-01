<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
    Route::get('/forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/email/verify', App\Livewire\Auth\VerifyEmail::class)->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Lien de vérification envoyé!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', App\Livewire\Dashboard\Home::class)->name('dashboard');
    
    Route::get('/dashboard/profiles', App\Livewire\Profile\Index::class)->name('profile.index');
    Route::get('/dashboard/profiles/create', App\Livewire\Profile\Create::class)->name('profile.create');
    Route::get('/dashboard/profiles/{profile}/edit', App\Livewire\Profile\EditTabs::class)->name('profile.edit');
    Route::post('/dashboard/profiles/add-additional', function() {
        return 'Achat profils additionnels - En construction';
    })->name('profile.add-additional');
});

// QR Code download (génération à la volée)
Route::middleware('auth')->get('/profile/{profile}/qr-download', function(App\Models\Profile $profile) {
    // Vérifier que le profil appartient à l'utilisateur
    if ($profile->user_id !== auth()->id()) {
        abort(403);
    }

    // Générer l'URL du profil public
    $profileUrl = route('profile.public', $profile->username);
    
    // Générer le QR code à la volée
    $qrCode = QrCode::format('png')
        ->size(500)
        ->margin(2)
        ->errorCorrection('H')
        ->generate($profileUrl);
    
    return response($qrCode)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="qrcode-' . $profile->username . '.png"');
})->name('profile.qr.download');

// Profile public
Route::get('/{username}', [ProfileController::class, 'show'])->name('profile.public');
