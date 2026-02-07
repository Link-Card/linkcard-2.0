<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('welcome');
});

// Stripe Webhook (SANS middleware CSRF)
Route::post('/webhook/stripe', [WebhookController::class, 'handleWebhook'])->name('stripe.webhook');

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

    Route::get('/email/verify', App\Livewire\Auth\VerifyEmailNotice::class)->name('verification.notice');
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
    Route::get('/dashboard/profiles/{profile}/edit', App\Livewire\Profile\EditProfile::class)->name('profile.edit');
    Route::get('/dashboard/subscription', App\Livewire\Subscription\Plans::class)->name('subscription.plans');
    Route::get('/dashboard/subscription/success', App\Livewire\Subscription\Success::class)->name('subscription.success');

    Route::post('/dashboard/profiles/add-additional', function() {
        return 'Achat profils additionnels - En construction';
    })->name('profile.add-additional');

    // Cartes NFC (dashboard)
    Route::get('/dashboard/cards', App\Livewire\Cards\Index::class)->name('cards.index');
    Route::get('/dashboard/cards/order', App\Livewire\Cards\Order::class)->name('cards.order');
    Route::get('/dashboard/cards/order/{order}/success', App\Livewire\Cards\OrderSuccess::class)->name('cards.order.success');
});

// QR Code download
Route::middleware('auth')->get('/profile/{profile}/qr-download', function(App\Models\Profile $profile) {
    if ($profile->user_id !== auth()->id()) {
        abort(403);
    }
    $profileUrl = route('profile.public', $profile->username);
    $qrCode = QrCode::format('png')
        ->size(500)
        ->margin(2)
        ->errorCorrection('H')
        ->generate($profileUrl);

    return response($qrCode)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="qrcode-' . $profile->username . '.png"');
})->name('profile.qr.download');

// vCard download
Route::get('/profile/{profile}/vcard', [ProfileController::class, 'downloadVcard'])->name('profile.vcard');

// NFC Card routes
use App\Http\Controllers\CardController;

Route::get('/c/{cardCode}', [CardController::class, 'redirect'])->name('card.redirect');
Route::get('/c/{cardCode}/activate', [CardController::class, 'showActivation'])->name('card.activate.show');
Route::post('/c/{cardCode}/activate', [CardController::class, 'activate'])->middleware('auth')->name('card.activate');

// Profile public (DOIT RESTER EN DERNIER)
Route::get('/{username}', [ProfileController::class, 'show'])->name('profile.public');
