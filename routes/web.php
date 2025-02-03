<?php

use App\Http\Controllers\PDFController;


Route::get('/MultiTools', [PDFController::class, 'index']);
Route::post('/convert-pdf', [PDFController::class, 'convert'])->name('pdf.convert');
