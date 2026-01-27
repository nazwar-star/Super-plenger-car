<?php

use App\Livewire\Home;
use App\Livewire\CarManager;
use App\Livewire\CarDetail;
use App\Livewire\ServiceManager;
use App\Livewire\Login;
use App\Livewire\Register;

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/home', Home::class)->name('home');

    Route::get('/', CarManager::class)->name('showroom');
    Route::get('/car/{id}', CarDetail::class)->name('car.detail');
    Route::get('/bengkel', ServiceManager::class)->name('service.manager');
});
