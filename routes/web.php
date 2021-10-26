<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home');
});

Route::post('/', [\App\Http\Controllers\FetchController::class,'search'])->name('search')->middleware('throttle:daily_limit');
Route::get('/get/video',[\App\Http\Controllers\FetchController::class,'downloadVideo'])->name('download.video');
Route::get('/get/audio',[\App\Http\Controllers\FetchController::class,'downloadAudio'])->name('download.audio');
