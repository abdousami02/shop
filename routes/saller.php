<?php
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
  return view('saller');
});

Route::get('/dashboard', function () {
  return view('saller');
});

Route::get('/dashboard/{any}', function ($any) {
  return view('saller');

})->where('any','.*');

Route::get('/{any}', function ($any) {
  return view('dashboard');

})->where('any','.*');

// Route::post('/login', [App\Http\Controllers\MainController::class, 'index'])->name('login');

