<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AntrianDokterController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\LiveAntrianController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PemeriksaanController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/rfid-tag', [App\Http\Controllers\RfidController::class, 'handleTag']);
Route::get('/antrian-tag', [App\Http\Controllers\RfidController::class, 'antrianTag']);
Route::get('/scan', [App\Http\Controllers\RfidController::class, 'scan']);
Route::get('/control-scan', [App\Http\Controllers\RfidController::class, 'controlScan']);


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// users
Route::resource('user', UserController::class);
// profile
Route::resource('profile', ProfileController::class);
// cuti
Route::group(['middleware' => ['auth', 'profile.check']], function () {
    Route::resource('pasien', PasienController::class)->middleware('auth');;
    Route::resource('antrian', AntrianController::class)->middleware('auth');;
    Route::resource('live', LiveAntrianController::class)->middleware('auth');;
    Route::get('/kartu', [App\Http\Controllers\RfidController::class, 'index'])->middleware('auth');;
    Route::resource('pelayanan', PelayananController::class)->middleware('auth');;
    Route::resource('pemeriksaan', PemeriksaanController::class)->middleware('auth');;
    Route::resource('antrianDokter', AntrianDokterController::class)->middleware('auth');;
    Route::resource('obat', ObatController::class)->middleware('auth');;
    Route::resource('cetak', CetakController::class)->middleware('auth');;
});
