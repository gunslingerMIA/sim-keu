<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MasterProgramController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/accounts', [AccountController::class, 'index'])->name('account.index');
Route::post('/accounts', [AccountController::class, 'store'])->name('account.store');

Route::prefix('programs')->group(function () {
    Route::get('/', [MasterProgramController::class, 'index'])->name('programs.index');
    Route::post('/store', [MasterProgramController::class, 'storeProgram'])->name('programs.store');
    Route::put('/update/{id}', [MasterProgramController::class, 'updateProgram']);
    Route::get('/delete/{id}', [MasterProgramController::class, 'deleteProgram']);
    Route::get('/kegiatan/delete/{id}', [MasterProgramController::class, 'deleteActivity']);
    Route::get('/sub/delete/{id}', [MasterProgramController::class, 'deleteSubActivity']);
    Route::post('/kegiatan/store', [MasterProgramController::class, 'storeKegiatan']);
    Route::put('/kegiatan/update/{id}', [MasterProgramController::class, 'updateKegiatan']);
    Route::post('/subkegiatan/store', [MasterProgramController::class, 'storeSubActivities']);
    Route::put('/subkegiatan/update/{id}', [MasterProgramController::class, 'updateSubActivities']);
        });

// Rute untuk menampilkan halaman Form Input
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

// Rute untuk memproses data yang dikirim dari Form (Method POST)
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

// Rute untuk AJAX (Dependent Dropdown)
Route::get('/get-activities/{programId}', [TransactionController::class, 'getActivities']);
Route::get('/get-sub-activities/{activityId}', [TransactionController::class, 'getSubActivities']);


