<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
Route::get('/', function () {
    return view('index');
});

Route::resource('siswa', SiswaController::class);
Route::resource('kelas', KelasController::class);
Route::resource('guru', GuruController::class);
Route::resource('data-absen', AbsenController::class);
Route::resource('admin', AdminController::class);

Auth::routes();
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.home')->middleware('is_admin');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/absen', [HomeController::class, 'absen'])->name('absen');
Route::post('/home-store', [HomeController::class, 'store'])->name('webcam.store');
Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile/{id}');
Route::get('/profilesiswa/{id}', [SiswaController::class, 'profile'])->name('profilesiswa/{id}');
Route::get('/guru/search', [GuruController::class, 'search'])->name('guru.search');
Route::get('/exportexcel', [AbsenController::class, 'export'])->name('exportexcel');
Route::post('/importexcel', [UserController::class, 'import'])->name('importexcel');
Route::post('/izin', [HomeController::class, 'izin'])->name('izin');
Route::get('/absen.filter', [AbsenController::class, 'index'])->name('absen.filter');
Route::get('/absens', [AbsenController::class, 'index'])->name('absens.index');
Route::get('/guru/{id}/destroy', [GuruController::class, 'destroy'])->name('guru.destroy');


Route::post('/in',[HomeController::class, 'in'])->name('in');

Route::post('/balik', [HomeController::class,'out'])->name('balik');

Route::post('/reset', function () {
    Absen::truncate();
    return redirect()->route('absens.index');
});

Route::get('/out', function () {
    return view('users.comeOut');
});
Route::get('/izin', function () {
    return view('users.izin');
});

