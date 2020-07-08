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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


