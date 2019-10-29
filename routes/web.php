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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::post('billing', 'BillingController@index')->name('billing');
Route::get('reprocess', 'BillingController@reprocess')->name('reprocess');

Route::get('subme', function(){
    //dd(auth()->user()->defaultPaymentMethod()->id);
    auth()->user()->newSubscription('main', 'starter')->create(auth()->user()->defaultPaymentMethod()->id);
})->name('subme');

