<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataMaster\ProvinsiController;
use App\Http\Controllers\DataMaster\KecamatanController;
use App\Http\Controllers\DataMaster\KelurahanController;

Route::get('/', function () {
    $data['title'] = 'Dashboard';
    return view('welcome', $data);
})->name('dashboard');
Route::group(['prefix' => 'data-master'], function () {
    Route::group(['prefix' => 'provinsi'], function () {
        Route::get('/', [ProvinsiController::class, 'index'])->name('provinsi');
        Route::post('/create', [ProvinsiController::class, 'create'])->name('create-provinsi');
        Route::post('/store', [ProvinsiController::class, 'store'])->name('store-provinsi');
        Route::post('/delete', [ProvinsiController::class, 'delete'])->name('delete-provinsi');
    });
    Route::group(['prefix' => 'kecamatan'], function () {
        Route::get('/', [KecamatanController::class, 'index'])->name('kecamatan');
        Route::post('/create', [KecamatanController::class, 'create'])->name('create-kecamatan');
        Route::post('/store', [KecamatanController::class, 'store'])->name('store-kecamatan');
        Route::post('/delete', [KecamatanController::class, 'delete'])->name('delete-kecamatan');
    });
    Route::group(['prefix' => 'kelurahan'], function () {
        Route::get('/', [KelurahanController::class, 'index'])->name('kelurahan');
        Route::post('/create', [KelurahanController::class, 'create'])->name('create-kelurahan');
        Route::post('/store', [KelurahanController::class, 'store'])->name('store-kelurahan');
        Route::post('/delete', [KelurahanController::class, 'delete'])->name('delete-kelurahan');
    });
});