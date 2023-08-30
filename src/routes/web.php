<?php

use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UploadFileController::class, 'view']);
Route::post('upload', [UploadFileController::class, 'upload'])->name('file.upload');
Route::get('status', [UploadFileController::class, 'status'])->name('file.status');
