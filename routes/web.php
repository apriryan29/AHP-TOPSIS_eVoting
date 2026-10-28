<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelayakanPdfController;
use App\Http\Controllers\HasilPemilihanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kelayakan/pdf', [KelayakanPdfController::class, 'generate'])
    ->name('kelayakan.pdf');
Route::get('/hasil-pemilihan/pdf', [HasilPemilihanController::class, 'exportPdf'])
    ->name('hasil-pemilihan.pdf');


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [LoginController::class, 'logout'])
    ->name('filament.admin.auth.logout');

//LUPA PASSWORD
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showReset'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');