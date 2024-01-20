<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\website\SettingController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
| this is admin router
|
*/
// Route::group([ 'middleware' => 'api', 'prefix' => 'auth'], function ($router) {
//   Route::post('login', 'AuthController@login');
//   Route::post('logout', 'AuthController@logout');
//   Route::post('refresh', 'AuthController@refresh');
//   Route::post('me', 'AuthController@me');
// });




/*
| auth admin
|
*/
Route::group(['middleware' => 'api', 'prefix' => 'auth-admin'], function ($router) {

  Route::post('login', [App\Http\Controllers\AuthAdminController::class, 'login']);
  Route::post('logout', [App\Http\Controllers\AuthAdminController::class, 'logout']);
  Route::post('refresh', [App\Http\Controllers\AuthAdminController::class, 'refresh']);
  Route::post('me', [App\Http\Controllers\AuthAdminController::class, 'me']);
});

/*
| auth user
|
*/
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
  Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
  Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
  Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
  Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);

});

// register signup
Route::post('signup', [App\Http\Controllers\website\SignUpController::class, 'default']);




/*
|  admin router
|
*/
Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function() {

  Route::post('product', [App\Http\Controllers\dashboard\ProductController::class, 'default']);
  Route::post('order', [App\Http\Controllers\dashboard\OrderController::class, 'default']);
  Route::post('order_detail', [App\Http\Controllers\dashboard\OrderDetailsController::class, 'default']);

  Route::post('cat', [App\Http\Controllers\dashboard\CategorieController::class, 'default']);
  Route::post('famille', [App\Http\Controllers\dashboard\FamillesController::class, 'default']);
  Route::post('store_type', [App\Http\Controllers\dashboard\StoreTypeController::class, 'default']);
  Route::post('store_info', [App\Http\Controllers\dashboard\StoreInfoController::class, 'default']);

  Route::post('user', [App\Http\Controllers\dashboard\UserController::class, 'default']);
  Route::post('group', [App\Http\Controllers\dashboard\GroupController::class, 'default']);
  Route::post('saller', [App\Http\Controllers\dashboard\SallerController::class, 'default']);

  Route::post('setting', [App\Http\Controllers\dashboard\AdminSettingController::class, 'default']);
  Route::post('anal', [App\Http\Controllers\dashboard\AnalController::class, 'default']);

});


Route::post('/setToken', [NotificationController::class, 'set']);


/*
|  saller router
|
*/
Route::group(['middleware' => 'auth:api', 'prefix' => 'saller'], function ($router) {

  Route::post('order', [App\Http\Controllers\saller\OrderController::class, 'default']);
  Route::post('order_detail', [App\Http\Controllers\saller\OrderDetailController::class, 'default']);
  Route::post('product', [App\Http\Controllers\saller\ProductController::class, 'default']);

});






/*
|  user router
|
*/
Route::post('setting', [App\Http\Controllers\SettingController::class, 'default']);

// for guest user
Route::post('guest', [App\Http\Controllers\GuestController::class, 'default']);



// for login user consumer
Route::group(['middleware' => 'api'], function ($router) {

  Route::post('store', [App\Http\Controllers\website\StoreController::class, 'default']);
  Route::post('order', [App\Http\Controllers\website\OrderController::class, 'default']);
  Route::post('order_detail', [App\Http\Controllers\website\OrderDetailController::class, 'default']);
  Route::post('checkout', [App\Http\Controllers\website\CheckoutController::class, 'default']);
  Route::post('setting', [App\Http\Controllers\website\SettingController::class, 'default']);

  Route::post('profile-info',[SettingController::class, 'profile']);
});

