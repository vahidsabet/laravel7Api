<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
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

/*
Route::get('orders', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Orders::all();
});
 
Route::get('orders/{id}', function($id) {
    return Orders::find($id);
});

Route::post('orders', function(Request $request) {
    return Orders::create($request->all);
});

Route::put('orders/{id}', function(Request $request, $id) {
    $Orders = Orders::findOrFail($id);
    $Orders->update($request->all());

    return $Orders;
});

Route::delete('orders/{id}', function($id) {
    Orders::find($id)->delete();

    return 204;
});
*/
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'api/v1/UserController@login');
*/

//Route::post('register', 'UserController@register');
//Route::post('refreshtoken', 'UserController@refreshToken');
     /*
Route::prefix('/user')->group(function(){
    Route::post('register', 'api\v1\user\UserController@register');
    Route::post('refreshtoken', 'api\v1\user\UserController@refreshToken');

        Route::post('login', 'api\v1\user\UserController@login');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::post('logout', 'api\v1\user\UserController@logout');
            Route::post('details', 'api\v1\user\UserController@details');
            Route::get('details', 'api\v1\user\UserController@details');
    });
});*/  


Route::group(['middleware' => ['auth:api']], function () {
        Route::get('orders', 'api\v1\orderController@index');
        Route::get('orders/{id}', 'api\v1\orderController@show');
        Route::post('orders/{id}', 'api\v1\orderController@search');
        Route::post('orders/store', 'api\v1\orderController@store');
        Route::put('orders/{id}', 'api\v1\orderController@update');
       // Route::delete('orders/{id}', 'api\v1\orderController@delete');

        Route::get('takorders', 'api\v1\takOrderController@index');
        Route::get('takorders/{id}', 'api\v1\takOrderController@show');
        Route::post('takorders/store', 'api\v1\takOrderController@store');
        Route::put('takorders/{id}', 'api\v1\takOrderController@update');

    });

Route::post('users/login', 'userLoginController@login');

Route::prefix('/user')->group(function(){
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('all','api\v1\user\userController@index');
        Route::post('register','api\v1\LoginController@register');
        Route::post('logout','api\v1\LoginController@logout');
        Route::post('change_password', 'api\v1\LoginController@change_password');
    });
   // Route::middleware('auth:api')->get('/all','api\v1\user\userController@index');
});
