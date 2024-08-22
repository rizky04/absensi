<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth/login');
    });
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');
});




Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/proseslogout', [AuthController::class, 'proseslogout'])->name('proseslogout');
    Route::resource('/presensi', PresensiController::class);
    Route::resource('/karyawan', KaryawanController::class);
    Route::get('/history', [PresensiController::class, 'history'])->name('history');
    Route::post('/gethistori', [PresensiController::class, 'gethistori'])->name('gethistori');
    Route::resource('/izin', IzinController::class);
});
