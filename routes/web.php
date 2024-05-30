<?php

use App\Http\Controllers\CnabController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cnab', [CnabController::class, 'uploadForm'])->name('cnab.uploadForm');
Route::post('/cnab/validate', [CnabController::class, 'validateCnab'])->name('cnab.validate');
