<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// পাবলিক রাউট
Route::get('/audio/{serial_number}', [AudioController::class, 'show'])->name('audio.show');
Route::get('/pdf/{serial_number}', [PdfController::class, 'download'])->name('pdf.download');
Route::get('/pdf/{serial_number}/download', [PdfController::class, 'directDownload'])->name('pdf.direct-download');

// অথেনটিকেশন রাউট
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// অ্যাডমিন রাউট (এখন auth মিডলওয়্যার দিয়ে সুরক্ষিত)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('audios', AudioController::class);
    Route::resource('pdfs', PdfController::class);
});