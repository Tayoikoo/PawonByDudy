<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CateringController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PawonController;
use App\Http\Controllers\PengirimController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pawonbydudy.index');
});

Route::controller(PawonController::class)->group(function() {
    Route::get('index', 'index')->name('pawonbydudy.index');
    Route::get('checkout', 'getCheckout')->name('pawonbydudy.checkout');
    Route::get('history', 'getHistoryOrder')->name('pawonbydudy.history_order');
    Route::get('kategori/{id_paket}', 'showKategori')->name('pawonbydudy.listkategori');
    Route::get('kategori/paket/{id_paket}', 'showInfo')->name('pawonbydudy.showinfopaket');
    Route::get('backend/account/user/{id_user}', 'backendAccount')->name('pawonbydudy.akun');
    Route::get('backend/account', 'showLogin')->name('pawonbydudy.showlogin');

    Route::post('backend/account/register', 'onRegister')->name('pawonbydudy.register');
    Route::post('backend/account/login', 'onLogin')->name('pawonbydudy.login');
    Route::post('backend/account/logout', 'logout')->name('pawonbydudy.logout');

    Route::put('backend/account/user/{id_user}/update', 'updateAccount')->name('pawonbydudy.akun.update');
});

Route::middleware('admin.auth')->group(function () {
    Route::get('admin-panel/beranda', [PawonController::class, 'indexAdmin'])->name('pawonbydudy.admin_index');

    // Admin
    Route::resource('admin-panel/beranda/admin', AdminController::class, ['as' => 'pawonbydudy_admin']);    
    Route::resource('admin-panel/beranda/user', UserController::class, ['as' => 'pawonbydudy_user']); 
    Route::resource('admin-panel/beranda/paket', PaketController::class, ['as' => 'pawonbydudy_paket']); 
    Route::resource('admin-panel/beranda/catering', CateringController::class, ['as' => 'pawonbydudy_catering']);
    Route::resource('admin-panel/beranda/pengirim', PengirimController::class, ['as' => 'pawonbydudy_pengirim']);
});

Route::middleware('user.auth')->group(function () {
    // Route::resource('')
});


