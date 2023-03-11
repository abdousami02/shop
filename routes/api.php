<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
| this is admin router
|
*/
// Route::group([

//   'middleware' => 'api',
//   'prefix' => 'auth'

// ], function ($router) {

//   Route::post('login', 'AuthController@login');
//   Route::post('logout', 'AuthController@logout');
//   Route::post('refresh', 'AuthController@refresh');
//   Route::post('me', 'AuthController@me');

// });

Route::group(['middleware' => 'auth:api'], function() {
  Route::post('product', [App\Http\Controllers\dashboard\ProductController::class, 'default']);
  Route::post('order', [App\Http\Controllers\dashboard\OrderController::class, 'default']);

  Route::post('cat', [App\Http\Controllers\dashboard\CategorieController::class, 'default']);
  Route::post('famille', [App\Http\Controllers\dashboard\FamillesController::class, 'default']);
  Route::post('store_type', [App\Http\Controllers\dashboard\StoreTypeController::class, 'default']);
  Route::post('store_info', [App\Http\Controllers\dashboard\StoreInfoController::class, 'default']);

  Route::post('user', [App\Http\Controllers\dashboard\UserController::class, 'default']);
  Route::post('group', [App\Http\Controllers\dashboard\GroupController::class, 'default']);
});


Route::group(['middleware' => 'api', 'prefix' => 'auth-admin'], function ($router) {

  Route::post('login', [App\Http\Controllers\AuthAdminController::class, 'login']);
  Route::post('logout', [App\Http\Controllers\AuthAdminController::class, 'logout']);
  Route::post('refresh', [App\Http\Controllers\AuthAdminController::class, 'refresh']);
  Route::post('me', [App\Http\Controllers\AuthAdminController::class, 'me']);

});


/*
|  user router
|
*/
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

  Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
  Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
  Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
  Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);

});


