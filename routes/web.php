<?php

use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AbsenController::class, 'index'])->name('absen.index');

Route::get('/log-absen', function () {
    return view('absensi');
})->name('absen.log');

Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
// Route::post('/proxy/recognize', [AbsenController::class, 'proxyToPython']);