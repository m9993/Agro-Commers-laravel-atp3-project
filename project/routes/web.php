<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'CustomerController@index')->name('login');
Route::get('/login', 'CustomerController@index')->name('login');
Route::get('/github', 'CustomerController@github')->name('customer.github');
Route::get('/github/redirect', 'CustomerController@githubRedirect')->name('customer.github.redirect');

Route::group(['middleware'=>['profile','role']], function(){
    Route::get('/logout', 'LogoutController@index')->name('customer.logout');
    Route::get('/home', 'CustomerController@home')->name('customer.home');
    Route::get('/searchProducts', 'CustomerController@searchProducts')->name('customer.searchProducts');

    Route::get('/cart', 'CustomerController@cart')->name('customer.cart');
    Route::post('/cart', 'CustomerController@order')->name('customer.order');
    Route::get('/add-to-cart/{pid}', 'CustomerController@addToCart')->name('customer.add-to-cart');
    Route::get('/add-by-one/{pid}', 'CustomerController@addByOne')->name('customer.add-by-one');
    Route::get('/reduce-by-one/{pid}', 'CustomerController@reduceByOne')->name('customer.reduce-by-one');
    Route::get('/remove/{pid}', 'CustomerController@remove')->name('customer.remove');
    
    Route::get('/history', 'CustomerController@history')->name('customer.history');
    Route::get('/order_details/{oid}', 'CustomerController@order_details')->name('customer.order_details');
    Route::post('/order_details/{oid}', 'CustomerController@add_review')->name('customer.order_details');
    Route::get('/generate_pdf/{oid}', 'CustomerController@generate_pdf')->name('customer.generate_pdf');

    Route::get('/view_product_review/{pid}', 'CustomerController@view_product_review')->name('customer.view_product_review');
    
    Route::post('/editProfile', 'CustomerController@editProfile')->name('customer.editProfile');

});
