<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpusAuthController;

// 1. Halaman utama bawaan Laravel (menampilkan welcome view)
Route::get('/', function () {
    return redirect('/perpus/login');
});

// 2. Kelompok Rute E-Perpustakaan Kampus (Prefiks /perpus)
Route::prefix('perpus')->group(function () {
    
    // Rute Registrasi Akun Perpustakaan
    Route::get('/register', [PerpusAuthController::class, 'register']);
    Route::post('/register', [PerpusAuthController::class, 'simpanRegister']);

    // Rute Login Akun Perpustakaan
    Route::get('/login', [PerpusAuthController::class, 'login'])->name('login');
    Route::post('/login', [PerpusAuthController::class, 'cekLogin']);

    // Rute yang wajib login terlebih dahulu (Middleware 'auth')
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [PerpusAuthController::class, 'dashboard']);
        Route::post('/logout', [PerpusAuthController::class, 'logout']);

        // Khusus Role Pustakawan
        Route::get('/kelola-buku', function () {
            return "<h1>Manajemen Koleksi Buku</h1><p>Halo Pustakawan! Anda memiliki akses penuh mengelola inventaris buku perpustakaan.</p><a href='/perpus/dashboard'>Kembali ke Dashboard</a>";
        })->middleware('role:pustakawan');

        // Khusus Role Anggota (Mahasiswa)
        Route::get('/pinjam-buku', function () {
            return "<h1>Peminjaman Buku Perpustakaan</h1><p>Silakan ajukan peminjaman buku perpustakaan.</p><a href='/perpus/dashboard'>Kembali ke Dashboard</a>";
        })->middleware('role:anggota');
        
    });
});