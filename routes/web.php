<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\YayasanController;
use Illuminate\Support\Facades\Route;

// Home landing page (or dashboard if authenticated)
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Protected Application Routes
Route::middleware(['auth'])->group(function () {
    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Mata Pelajaran Saya & Workspace Hierarki (CP -> TP -> Materi)
    Route::get('/mata-pelajaran', [CurriculumController::class, 'index'])->name('curriculum.index');
    Route::post('/usulan/store', [CurriculumController::class, 'storeProposal'])->name('curriculum.proposal.store');

    // 3. Riwayat Usulan & Pelacak Status Kurikulum
    Route::get('/usulan', [ProposalController::class, 'index'])->name('usulan.index');
    Route::get('/usulan/json/{usulan}', [ProposalController::class, 'show'])->name('usulan.show');
    Route::post('/usulan/{usulan}/review', [ProposalController::class, 'review'])->name('usulan.review');

    // 4. Pusat Bantuan & Panduan Guru (SOP & FAQ)
    Route::get('/panduan', [GuideController::class, 'index'])->name('guide.index');

    // 5. Kegiatan Kokurikuler (P5-RA) & Ekstrakurikuler
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');

    // 6. Jurnal Kerja, Jurnal Mengajar Digital & Monitoring Tahfidz
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::post('/jurnal/store', [JurnalController::class, 'storeJurnal'])->name('jurnal.store');
    Route::post('/jurnal/remind/{id}', [JurnalController::class, 'remindGuruKbm'])->name('jurnal.remind');
    Route::post('/tahfidz/store', [JurnalController::class, 'storeTahfidz'])->name('tahfidz.store');
    Route::post('/jurnal-kerja/store', [JurnalController::class, 'storeJurnalKerja'])->name('jurnal-kerja.store');
    Route::post('/jurnal-kerja/{id}/toggle', [JurnalController::class, 'toggleJurnalKerja'])->name('jurnal-kerja.toggle');
    Route::delete('/jurnal-kerja/{id}', [JurnalController::class, 'destroyJurnalKerja'])->name('jurnal-kerja.destroy');

    // 7. Monitoring Kurikulum Terpadu Seluruh Unit (Khusus Pengurus Yayasan)
    Route::get('/yayasan/monitoring', [YayasanController::class, 'index'])->name('yayasan.monitoring');

    // 8. Manajemen Akun Pengguna & Hak Akses (Khusus Admin Sistem)
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/admin/assign-mapel', [AdminController::class, 'assignMapel'])->name('admin.assign.mapel');

    // 9. Arsip Kurikulum, Modul Ajar & Portofolio Pengawasan Tahunan
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::post('/arsip/store', [ArsipController::class, 'store'])->name('arsip.store');
    Route::post('/arsip/{id}/status', [ArsipController::class, 'updateStatus'])->name('arsip.status');
    Route::delete('/arsip/{id}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    // 10. Sinkronisasi Realtime & Notifikasi
    Route::get('/realtime/sync', [\App\Http\Controllers\RealtimeController::class, 'sync'])->name('realtime.sync');
    Route::get('/realtime/stream', [\App\Http\Controllers\RealtimeController::class, 'stream'])->name('realtime.stream');
    Route::post('/realtime/notifications/{notifikasi}/read', [\App\Http\Controllers\RealtimeController::class, 'markAsRead'])->name('realtime.read');
    Route::post('/realtime/notifications/read-all', [\App\Http\Controllers\RealtimeController::class, 'markAllAsRead'])->name('realtime.read-all');
});
