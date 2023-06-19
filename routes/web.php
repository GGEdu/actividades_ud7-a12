<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('login');
})->name('login');
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('register');
});

Route::middleware(['auth', 'loadSections'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');
    Route::get('/weather', [WeatherController::class, 'showWeatherForm'])->name('weather');
    Route::get('/get-weather', [WeatherController::class, 'getWeather'])->name('getWeather');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::get('/csrf-token', function() {
    return csrf_token();
});



