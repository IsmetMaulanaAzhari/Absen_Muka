<?php

use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AbsenController::class, 'index'])->name('absen.index');

Route::get('/absen', [AbsenController::class, 'history'])->name('absen.history');

Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');