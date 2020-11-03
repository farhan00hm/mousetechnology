<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/create-licence-key',[\App\Http\Controllers\LicenceController::class,'create'])->name('create-licence-key')->middleware('auth');
Route::get('/user/{id}',[\App\Http\Controllers\LicenceController::class,'show'])->name('findUserById')->middleware('auth');
Route::post('/user/save-key',[\App\Http\Controllers\LicenceController::class,'update'])->name('save-licence-key')->middleware('auth');
Route::get('/enter-licence-key',[\App\Http\Controllers\LicenceController::class,'enterLicenceKey'])->name('enter-licence-key')->middleware('auth');
Route::get('/active-licence-key',[\App\Http\Controllers\LicenceController::class,'activeLicenceKey'])->name('active-licence-key')->middleware('auth');
