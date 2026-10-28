<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KandidatController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PemilihanController;
use App\Http\Controllers\Api\VotingController;
use App\Http\Controllers\Api\ProfileController;


Route::get('/kandidats', [KandidatController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/pemilihan', [PemilihanController::class, 'pemilihan']);


Route::post('/kirimtoken', [VotingController::class, 'kirimToken']);
Route::get('/cek-verifikasi/{id}', [VotingController::class, 'cekVerifikasi']);
Route::post('/verifikasitoken', [VotingController::class, 'verifikasiToken']);
Route::post('/simpanpilihan', [VotingController::class, 'simpanPilihan']);
Route::get('/hasil-suara', [VotingController::class, 'hasilSuara']);

// ── Profile (tanpa Sanctum, identifikasi user via user_id yang dikirim dari Flutter) ──
Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::put('/profile/{id}', [ProfileController::class, 'update']);
Route::post('/profile/{id}/change-password', [ProfileController::class, 'changePassword']);