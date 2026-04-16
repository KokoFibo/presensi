<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::livewire('/presensi', 'components/presensi')->middleware(['auth', 'verified'])->layout('layouts.app');
// Route::livewire('/presensi', 'presensi')->name('presensi');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('presensi');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::livewire('/presensi', 'presensi')
    ->middleware(['auth', 'verified'])
    ->name('presensi');

Route::livewire('/slip-gaji', 'slipgaji')
    ->middleware(['auth', 'verified'])
    ->name('slipgaji');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
