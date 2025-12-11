<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('landing');
});

// Authentication routes
Route::get('/masuk', [AuthController::class, 'showLayananLogin'])->name('login.portal');
Route::get('/masuk/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::get('/masuk/profesional', [AuthController::class, 'showProfesionalLogin'])->name('login.profesional');
Route::get('/masuk/klien', [AuthController::class, 'showKlienLogin'])->name('login'); // Default login name
Route::post('/masuk', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/daftar', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard - redirects based on user role
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Report routes
        Route::get('/laporan', [AdminController::class, 'laporanIndex'])->name('laporan.index');
        Route::get('/laporan/menunggu', [AdminController::class, 'laporanMenunggu'])->name('laporan.menunggu');
        Route::get('/laporan/{id}', [AdminController::class, 'laporanShow'])->name('laporan.show');
        Route::get('/laporan/{id}/edit', [AdminController::class, 'laporanEdit'])->name('laporan.edit');
        Route::put('/laporan/{id}', [AdminController::class, 'laporanUpdate'])->name('laporan.update');
        Route::delete('/laporan/{id}', [AdminController::class, 'laporanDestroy'])->name('laporan.destroy');
        Route::put('/laporan/{id}/status', [AdminController::class, 'laporanUpdateStatus'])->name('laporan.update-status');
        Route::post('/laporan/{id}/assign', [AdminController::class, 'assignProfesional'])->name('laporan.assign');
        
        // Consultation routes
        Route::get('/konsultasi', [AdminController::class, 'konsultasiIndex'])->name('konsultasi.index');
        Route::get('/konsultasi/{id}', [AdminController::class, 'konsultasiShow'])->name('konsultasi.show');
        
        // Consultation Report routes
        Route::get('/laporan-konsultasi', [AdminController::class, 'laporanKonsultasiIndex'])->name('laporan-konsultasi.index');
        Route::get('/laporan-konsultasi/aktif', [AdminController::class, 'laporanKonsultasiAktif'])->name('laporan-konsultasi.aktif');
        Route::get('/laporan-konsultasi/selesai', [AdminController::class, 'laporanKonsultasiSelesai'])->name('laporan-konsultasi.selesai');
        Route::get('/laporan-konsultasi/profesional/{id}', [AdminController::class, 'laporanKonsultasiProfesional'])->name('laporan-konsultasi.profesional');
        
        
        // Professional routes
        Route::get('/profesional', [AdminController::class, 'profesionalIndex'])->name('profesional.index');
        Route::get('/profesional/menunggu', [AdminController::class, 'profesionalMenunggu'])->name('profesional.menunggu');
        Route::get('/profesional/create', [AdminController::class, 'profesionalCreate'])->name('profesional.create');
        Route::post('/profesional', [AdminController::class, 'profesionalStore'])->name('profesional.store');
        Route::get('/profesional/{id}', [AdminController::class, 'profesionalShow'])->name('profesional.show');
        Route::get('/profesional/{id}/edit', [AdminController::class, 'profesionalEdit'])->name('profesional.edit');
        Route::put('/profesional/{id}', [AdminController::class, 'profesionalUpdate'])->name('profesional.update');
        Route::put('/profesional/{id}/status', [AdminController::class, 'profesionalUpdateStatus'])->name('profesional.update-status');
        Route::delete('/profesional/{id}', [AdminController::class, 'profesionalDestroy'])->name('profesional.destroy');
    });
    
    // Profesional routes
    Route::prefix('profesional')->name('profesional.')->middleware('role:profesional')->group(function () {
        Route::get('/dashboard', [ProfessionalController::class, 'dashboard'])->name('dashboard');
        Route::get('/konsultasi', [ProfessionalController::class, 'konsultasiIndex'])->name('konsultasi');
        Route::get('/konsultasi/{id}', [ProfessionalController::class, 'konsultasiDetail'])->name('konsultasi.detail');
        Route::get('/konsultasi/{id}/chat', [ProfessionalController::class, 'konsultasiChat'])->name('konsultasi.chat');
        Route::post('/konsultasi/{id}/pesan', [ProfessionalController::class, 'kirimPesan'])->name('konsultasi.pesan');
        Route::patch('/konsultasi/{id}/selesai', [ProfessionalController::class, 'selesaiKonsultasi'])->name('konsultasi.selesai');
    });
    
    // Klien routes
    Route::prefix('klien')->name('klien.')->middleware('role:klien')->group(function () {
        Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        
        // Profile routes
        Route::get('/profil', [ClientController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profil', [ClientController::class, 'updateProfile'])->name('profile.update');
        
        // Laporan routes
        Route::get('/laporan-saya', [ClientController::class, 'laporanIndex'])->name('laporan.index');
        Route::get('/laporan/buat', [ClientController::class, 'laporanCreate'])->name('laporan.create');
        Route::post('/laporan', [ClientController::class, 'laporanStore'])->name('laporan.store');
        Route::get('/laporan/{id}', [ClientController::class, 'laporanShow'])->name('laporan.show');
        
        // Konsultasi routes
        Route::get('/konsultasi', [ClientController::class, 'konsultasiIndex'])->name('konsultasi.index');
        Route::get('/konsultasi/{id}/chat', [ClientController::class, 'konsultasiChat'])->name('konsultasi.chat');
        Route::post('/konsultasi/{id}/pesan', [ClientController::class, 'konsultasiSendMessage'])->name('konsultasi.pesan');
    });
});
