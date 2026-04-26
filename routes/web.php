<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MasterProgramController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/pilih-tahun', [AuthController::class, 'pilihTahun'])->name('tahun.pilih');
    Route::post('/pilih-tahun', [AuthController::class, 'simpanTahun'])->name('tahun.simpan');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/accounts', [AccountController::class, 'index'])->name('account.index');
    Route::post('/accounts/store', [AccountController::class, 'store'])->name('account.store');
    Route::put('/accounts/update/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::get('accounts/delete/{id}', [AccountController::class, 'delete'])->name('account.delete');

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
});





Route::prefix('users')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::put('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::prefix('budgets')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/store', [BudgetController::class, 'store'])->name('budgets.store');
    Route::post('/replicate', [BudgetController::class, 'replicate'])->name('budgets.replicate');
    // Route::post('/ganti-tahapan', [BudgetController::class, 'gantiTahapan'])->name('budgets.ganti-tahapan');
    Route::get('/rinci/{sub_id}', [BudgetController::class, 'rincian'])->name('budgets.rinci');
    Route::get('/delete/{id}', [BudgetController::class, 'delete'])->name('budgets.delete');
});

// Rute untuk menampilkan halaman Form Input
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

// Rute untuk memproses data yang dikirim dari Form (Method POST)
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

// Rute untuk AJAX (Dependent Dropdown)
Route::get('/get-activities/{programId}', [TransactionController::class, 'getActivities']);
Route::get('/get-sub-activities/{activityId}', [TransactionController::class, 'getSubActivities']);


