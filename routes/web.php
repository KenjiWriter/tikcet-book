<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// GŁÓWNA STRONA - HOME zamiast welcome
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth status endpoint
Route::get('/auth/status', function() {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user() ? [
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'avatar' => auth()->user()->avatar ?? '👤'
        ] : null
    ]);
})->name('auth.status');

// Destynacje
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{name}', [DestinationController::class, 'show'])->name('destinations.show');

// Atrakcje
Route::get('/attractions', [AttractionController::class, 'index'])->name('attractions.index');

// Wyszukiwanie
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Rezerwacje
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('/booking/{booking}/payment', [BookingController::class, 'processPayment'])->name('booking.processPayment');
Route::get('/booking/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.myBookings');
Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

// Auth routes - using Livewire components
Route::get('login', App\Livewire\Auth\Login::class)->name('login');
Route::get('register', App\Livewire\Auth\Register::class)->name('register');
Route::get('forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('password.request');
Route::get('reset-password/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', App\Livewire\Auth\VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', App\Http\Controllers\Auth\VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', App\Livewire\Auth\ConfirmPassword::class)
        ->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

// Social Auth routes
Route::get('/auth/google', [App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/auth/apple', [App\Http\Controllers\SocialAuthController::class, 'redirectToApple'])->name('auth.apple');
Route::get('/auth/apple/callback', [App\Http\Controllers\SocialAuthController::class, 'handleAppleCallback'])->name('auth.apple.callback');

Route::get('/auth/facebook', [App\Http\Controllers\SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [App\Http\Controllers\SocialAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

Route::get('/auth/twitter', [App\Http\Controllers\SocialAuthController::class, 'redirectToTwitter'])->name('auth.twitter');
Route::get('/auth/twitter/callback', [App\Http\Controllers\SocialAuthController::class, 'handleTwitterCallback'])->name('auth.twitter.callback');

Route::get('/auth/github', [App\Http\Controllers\SocialAuthController::class, 'redirectToGitHub'])->name('auth.github');
Route::get('/auth/github/callback', [App\Http\Controllers\SocialAuthController::class, 'handleGitHubCallback'])->name('auth.github.callback');

// Statyczne strony
Route::view('/about', 'about')->name('about');

// Kontakt
Route::get('/contact', function() { return view('contact.index'); })->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Dashboard route removed - using home page instead

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
