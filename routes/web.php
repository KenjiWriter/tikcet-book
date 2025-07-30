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

// Destynacje
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{id}', [DestinationController::class, 'show'])->name('destinations.show');

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

// Statyczne strony
Route::view('/about', 'about')->name('about');

// Kontakt
Route::get('/contact', function() { return view('contact.index'); })->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
