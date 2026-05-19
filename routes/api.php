<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DokumenController;

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);

// Master Data Routes
Route::get('/kegiatan', [MasterDataController::class, 'getKegiatan']);
Route::get('/tim', [MasterDataController::class, 'getTim']);
Route::get('/subtim', [MasterDataController::class, 'getSubTim']);

// Dashboard Progress & History Routes
Route::get('/progress/{id}', [DashboardController::class, 'getProgress']);
Route::get('/progress-history/{id}', [DashboardController::class, 'getHistory']);
Route::get('/progress-edit/{id}', [DashboardController::class, 'getProgressEdit']);
Route::put('/progress/{id}', [DashboardController::class, 'updateProgress']);

// Kegiatan Routes
Route::post('/kegiatan', [KegiatanController::class, 'createKegiatan']);
Route::put('/kegiatan/{id}', [KegiatanController::class, 'editKegiatan']);
Route::delete('/kegiatan/{id}', [KegiatanController::class, 'deleteKegiatan']);

// User Management Routes
Route::get('/user', [UserController::class, 'getUsers']);
Route::post('/user', [UserController::class, 'createUser']);
Route::put('/user/{id}', [UserController::class, 'editUser']);
Route::delete('/user/{id}', [UserController::class, 'deleteUser']);

// Dokumen Routes
Route::post('/dokumen', [DokumenController::class, 'saveDokumen']);
