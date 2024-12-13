<?php

use App\Http\Controllers\PDFcontroller;
use Filament\Http\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download-riwayat/{id}', [PDFController::class, 'downloadRiwayat'])->name('download.riwayat');

Route::get('jadwal/pdf', [PDFController::class, 'viewJadwalPDF'])->name('download.jadwal');
