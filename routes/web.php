<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

Route::middleware('role:admin')->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/ibu', App\Http\Controllers\Admin\IbuController::class)->names('admin.ibu');
        Route::get('/ibu/{id}/detail', [App\Http\Controllers\Admin\IbuController::class, 'detail'])->name('admin.ibu.detail');

        Route::resource('/kehamilan', App\Http\Controllers\Admin\KehamilanController::class)->names('admin.kehamilan');
        Route::get('/table/kehamilan', [App\Http\Controllers\Admin\KehamilanController::class, 'table'])->name('admin.kehamilan.table');

        Route::get('/kehamilan/{id}/detail', [App\Http\Controllers\Admin\KehamilanController::class, 'detail'])->name('admin.kehamilan.detail');
        Route::get('/kehamilan/{id}/detailNifas', [App\Http\Controllers\Admin\KehamilanController::class, 'detailNifas'])->name('admin.kehamilan.detail.nifas');
        Route::get('/kehamilan/{id}/detailPelayanan', [App\Http\Controllers\Admin\KehamilanController::class, 'detailPelayanan'])->name('admin.kehamilan.detail.pelayanan');
        Route::get('/kehamilan/{id}/detailTtd', [App\Http\Controllers\Admin\KehamilanController::class, 'detailTtd'])->name('admin.kehamilan.detail.ttd');

        Route::get('/kehamilan/{kehamilan}/kalender', [App\Http\Controllers\Admin\KehamilanController::class, 'kalender'])->name('kehamilan.kalender');
        Route::get('/kehamilan/{kehamilan}/kalender/events', [App\Http\Controllers\Admin\KehamilanController::class, 'getTanggalEvents'])->name('kehamilan.kalender.events');
        Route::post('/kehamilan/ttd/{ttd}/toggle', [App\Http\Controllers\Admin\KehamilanController::class, 'toggleTanggal'])->name('kehamilan.ttd.toggle');

        Route::resource('/pelayanan', App\Http\Controllers\Admin\PelayananController::class)->names('admin.pelayanan');
        Route::get('/pelayanan/{id}/detail', [App\Http\Controllers\Admin\PelayananController::class, 'detail'])->name('admin.pelayanan.detail');

        Route::get('/periksa/{id}', [App\Http\Controllers\Admin\PeriksaKehamilanController::class, 'index'])->name('admin.periksa.index');
        Route::get('table/periksa/{id}', [App\Http\Controllers\Admin\PeriksaKehamilanController::class, 'table'])->name('admin.periksa.table');
        Route::get('/periksa/{id}/edit', [App\Http\Controllers\Admin\PeriksaKehamilanController::class, 'edit'])->name('admin.periksa.edit');
        Route::get('/form/periksa/edit', [App\Http\Controllers\Admin\PeriksaKehamilanController::class, 'getForm'])->name('admin.periksa.form.edit');
        Route::get('/periksa/form', [App\Http\Controllers\Admin\PeriksaKehamilanController::class, 'getFormEdit'])->name('admin.periksa.form');

        Route::resource('/nifas', App\Http\Controllers\Admin\NifasController::class)->names('admin.nifas');
        Route::get('/nifas/{id}/detail', [App\Http\Controllers\Admin\NifasController::class, 'detail'])->name('admin.nifas.detail');

        Route::resource('/rujukan', App\Http\Controllers\Admin\RujukanController::class)->names('admin.rujukan');
        Route::get('table/rujukan', [App\Http\Controllers\Admin\RujukanController::class, 'table'])->name('admin.rujukan.table');

        Route::resource('/form', App\Http\Controllers\Admin\FormPeriksaKehamilanController::class)->names('admin.form');
        Route::get('/form/{id}/detail', [App\Http\Controllers\Admin\FormPeriksaKehamilanController::class, 'detail'])->name('admin.form.detail');

        Route::resource('/user', App\Http\Controllers\Admin\UserController::class)->names('admin.user');
        Route::get('table/user', [App\Http\Controllers\Admin\UserController::class, 'table'])->name('admin.user.table');

        Route::get('/pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('admin.pengaturan');
        Route::put('/pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('admin.pengaturan.update');

        Route::get('/profile', [App\Http\Controllers\Admin\UserController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [App\Http\Controllers\Admin\UserController::class, 'profile'])->name('admin.profile.update');
        Route::post('/profile/password', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.profile.password.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('role:ibu')->group(function () {
    Route::prefix('ibu')->group(function () {
        Route::get('/', [App\Http\Controllers\Ibu\DashboardController::class, 'index'])->name('ibu.dashboard');

        Route::get('/table/{id}/kehamilan', [App\Http\Controllers\Ibu\KehamilanController::class, 'table'])->name('ibu.kehamilan.table');
        Route::get('/table/{id}/nifas', [App\Http\Controllers\Ibu\NifasController::class, 'table'])->name('ibu.nifas.table');
        Route::get('/table/{id}/pelayanan', [App\Http\Controllers\Ibu\PelayananController::class, 'table'])->name('ibu.pelayanan.table');

        Route::get('/kehamilan', [App\Http\Controllers\Ibu\KehamilanController::class, 'index'])->name('ibu.kehamilan.index');
        Route::get('/kehamilan/{id}/detail', [App\Http\Controllers\Ibu\KehamilanController::class, 'detail'])->name('ibu.kehamilan.detail');

        Route::get('/periksa', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'index'])->name('ibu.periksa.index');
        Route::get('/table/periksa', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'table'])->name('ibu.periksa.table');
        Route::get('/periksa/{id}/tambah', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'tambah'])->name('ibu.periksa.tambah');
        Route::get('/periksa/{id}/edit', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'edit'])->name('ibu.periksa.edit');
        Route::put('/periksa', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'update'])->name('ibu.periksa.update');
        Route::get('/periksa/form', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'getForm'])->name('ibu.periksa.form');
        Route::get('/periksa/form/edit', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'getFormEdit'])->name('ibu.periksa.form.edit');
        Route::post('/periksa', [App\Http\Controllers\Ibu\PeriksaKehamilanController::class, 'store'])->name('ibu.periksa.store');

        Route::get('/kehamilan/{kehamilan}/kalender', [App\Http\Controllers\Ibu\KehamilanController::class, 'kalender'])->name('ibu.kehamilan.kalender');
        Route::get('/kehamilan/{kehamilan}/kalender/events', [App\Http\Controllers\Ibu\KehamilanController::class, 'getTanggalEvents'])->name('ibu.kehamilan.kalender.events');
        Route::post('/kehamilan/ttd/{ttd}/toggle', [App\Http\Controllers\Ibu\KehamilanController::class, 'toggleTanggal'])->name('ibu.kehamilan.ttd.toggle');

        Route::get('/rujukan', [App\Http\Controllers\Ibu\RujukanController::class, 'index'])->name('ibu.rujukan.index');
        Route::get('/table/rujukan', [App\Http\Controllers\Ibu\RujukanController::class, 'table'])->name('ibu.rujukan.table');

        Route::get('/profile', [App\Http\Controllers\Ibu\IbuController::class, 'profile'])->name('ibu.profile');
        Route::put('/profile', [App\Http\Controllers\Ibu\IbuController::class, 'profile'])->name('ibu.profile.update');
    });
});
