<?php

use App\Models\Dosen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\isiKelasController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MahasiswaController;
use App\Models\Kelas;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Test
// Test End
Route::middleware(['guest'])->group(function(){
    Route::get('/',[\App\Http\Controllers\SessionController::class,'index']);
    Route::post('login',[\App\Http\Controllers\SessionController::class,'login'])->name('login');
});
Route::get('testing', function () {
    return Auth::user();
});

Route::middleware(['auth'])->group(function(){
    Route::get('/Welcome',function(){
        return view('Welcome');
    });
    Route::get('/logout',[\App\Http\Controllers\SessionController::class,'logout']);

    Route::get('/Mahasiswa',[\App\Http\Controllers\MahasiswaController::class,'show']);
    Route::post('/keterangan',[App\Http\Controllers\MahasiswaController::class,'store']);
    Route::get('EditMahasiswaForm/{id}',[\App\Http\Controllers\MahasiswaController::class,'formEditMahasiswa']);
    Route::post('EditMahasiswa/{id}',[\App\Http\Controllers\MahasiswaController::class,'update'])->name('EditMahasiswa');
    
    // Kaprodi
    Route::get('/kaprodi', function () {
        return view('Kaprodi/Kaprodi');
    })->middleware('role:Kaprodi');
    // Route::get('/dosen', function () {
    //     return view('Dosen');
    // });
    // Route::get('/kaprodi_addDosen', function () {
    //     return view('Kaprodi/Kaprodi_AddDosen');
    // });

    Route::resource('viewisiKelas',isiKelasController::class);
    Route::resource('DataDosen', DosenController::class);
    Route::resource('mahasiswa', MahasiswaController::class);

    // Error gk bisa terbaca routing yang ini
    Route::get('keterangan/dec/{id}',[\App\Http\Controllers\DosenController::class,'decline'])->middleware('role:Dosen');
    Route::get('keterangan/acc/{id}',[\App\Http\Controllers\DosenController::class,'approve'])->middleware('role:Dosen');

    Route::get('viewData',[App\Http\Controllers\KelasController::class,'index'])->middleware('role:Kaprodi');
    Route::get('viewData/{id}',[App\Http\Controllers\KelasController::class,'show'])->middleware('role:Kaprodi');
    Route::get('Data_kelas',[App\Http\Controllers\KelasController::class,'dataKelas'])->middleware('role:Dosen');
    Route::get('viewData/{id}/update',[App\Http\Controllers\KelasController::class,'update'])->middleware('role:Kaprodi');
    Route::get('viewData/{id}/{mid}/edit',[App\Http\Controllers\KelasController::class,'edit'])->middleware('role:Kaprodi');
    Route::get('DataMahasiswa/{id}',[App\Http\Controllers\MahasiswaController::class,'index'])->middleware('role:Kaprodi');
    Route::get('kelas/{id}/show',[App\Http\Controllers\DosenController::class,'show'])->middleware('role:Kaprodi');
    Route::get('kelas/{id}%{kId}/edit',[App\Http\Controllers\DosenController::class,'edit'])->middleware('role:Kaprodi');
});