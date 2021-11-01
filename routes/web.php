<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/terms', function () {
    return view('terms_condition');
})->name('terms-conditons');
Route::get('/privacy-policy', function () {
    return view('privacy_policy');
})->name('policy');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::post('/', [\App\Http\Controllers\FetchController::class,'search'])->name('search')->middleware('throttle:daily_limit');
Route::get('/get/video',[\App\Http\Controllers\FetchController::class,'downloadVideo'])->name('download.video');
Route::get('/get/audio',[\App\Http\Controllers\FetchController::class,'downloadAudio'])->name('download.audio');
