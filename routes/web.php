<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/home', 'AdminController@index')->name('home');

/*
 * Admin Routes
 */
Route::get('/spares',function (){
    return view('admin.spares');
});
Route::get('/get_spares_json','AdminController@get_spares_json');
Route::post('/add/spares','AdminController@add_spares')->name('add_spares');
Route::post('/edit/spares','AdminController@edit_spares')->name('edit_spares');
Route::post('/suspend/spares','AdminController@suspend_spares')->name('suspend_spares');
Route::post('/restore/spares','AdminController@restore_spares')->name('restore_spares');

/*
 * Mechanics Routes
 */
Route::get('/mechanic/home','MechanicController@index')->name('mechanic_home');

