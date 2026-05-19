<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });
Route::get('/index.html', function () { return view('welcome'); });
Route::get('/dashboard_kegiatan.html', function () { return view('dashboard_kegiatan'); });
Route::get('/login.html', function () { return view('login'); });
Route::get('/admin_monitoring.html', function () { return view('admin_monitoring'); });
Route::get('/tentang.html', function () { return view('tentang'); });
Route::get('/admin_informasi.html', function () { return view('admin_informasi'); });
Route::get('/admin_kegiatan.html', function () { return view('admin_kegiatan'); });
Route::get('/admin_user.html', function () { return view('admin_user'); });
