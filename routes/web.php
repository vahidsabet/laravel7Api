<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('orders/orderState', 'orderController@orderState');
//Route::post('users/login', 'userLoginController@login');

/*
//Route::resource('orders', 'orderController');
Route::get('orders', 'orderController@index');
//Route::resource('orders', 'orderController@index');
Route::get('orders/{id}', 'orderController@show');
Route::post('orders/store', 'orderController@store');
Route::put('orders/{id}', 'orderController@update');
Route::delete('orders/{id}', 'orderController@delete');
*/
//Route::post('user/create', 'Auth\RegisterController@userCreate');

//Auth::routes();

Route::get('/dashboard', 'DashboardController@index');//->name('home');
