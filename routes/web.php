<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\CarManager;
use App\Livewire\ServiceManager;
use App\Livewire\Contact;
use App\Livewire\MasukanRating;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\CarDetail;
use Illuminate\Support\Facades\Auth;
use App\Livewire\UserOrderHistory;
use App\Livewire\Admin\AdminRentalApproval;
use App\Livewire\Admin\AdminRequest;


// Home
Route::get('/', Home::class)->name('home');

// Stock / Car Manager
Route::get('/stock', CarManager::class)->name('stock');

// Detail Mobil (Livewire dengan parameter)

Route::get('/car/{id}', CarDetail::class)->name('car.detail');


// Service
Route::get('/bengkel', ServiceManager::class)->name('service');


// USER
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', UserOrderHistory::class)
        ->name('user.orders');
});

Route::middleware(['auth','admin'])->group(function () {

    Route::get('/admin/request', AdminRequest::class)
        ->name('admin.request');

    Route::get('/admin/request/{order}', AdminRentalApproval::class)
        ->name('admin.request.approval');

});



// Contact & Feedback

Route::get('/masukan-rating', MasukanRating::class)->name('masukan.rating');


// Auth
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');
