<?php
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
  return view('admin');
});

Route::get('/dashboard', function () {
  return view('dashboard');
});

Route::get('/dashboard/{any}', function ($any) {
  return view('dashboard');

})->where('any','.*');

Route::get('/{any}', function ($any) {
  return view('admin');

})->where('any','.*');


