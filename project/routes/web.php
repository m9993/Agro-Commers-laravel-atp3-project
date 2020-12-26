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
Route::get('/', 'CustomerController@index')->name('index');
Route::get('/github', 'CustomerController@github')->name('customer.github');
Route::get('/github/redirect', 'CustomerController@githubRedirect')->name('customer.github.redirect');
Route::get('/home', 'CustomerController@home')->name('customer.home');
