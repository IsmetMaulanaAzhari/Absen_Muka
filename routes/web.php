<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');