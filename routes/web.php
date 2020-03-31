<?php

use App\Pricing;
use App\Service;
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
Route::get('/get_spares_json','SpareController@get_spares_json');
Route::post('/add/spares','SpareController@add_spares')->name('add_spares');
Route::post('/edit/spares','SpareController@edit_spares')->name('edit_spares');
Route::post('/suspend/spares','SpareController@suspend_spares')->name('suspend_spares');
Route::post('/restore/spares','SpareController@restore_spares')->name('restore_spares');

Route::get('/get_vehicle_categories_json','VehicleCategoriesController@get_vehicle_categories_json');
Route::post('/add/vehicle_category','VehicleCategoriesController@add_vehicle_category');
Route::post('/suspend/vehicle_category','VehicleCategoriesController@suspend_vehicle_category');
Route::post('/restore/vehicle_category','VehicleCategoriesController@restore_vehicle_category');

Route::get('/get_vehicle_types_json','VehicleTypesController@get_vehicle_types_json');
Route::post('/add/vehicle_type','VehicleTypesController@add_vehicle_type');
Route::post('/suspend/vehicle_type','VehicleTypesController@suspend_vehicle_type');
Route::post('/restore/vehicle_type','VehicleTypesController@restore_vehicle_type');

Route::get('/get_garage_services_json','GarageServicesController@get_garage_services_json');
Route::post('/add/garage_service','GarageServicesController@add_garage_service');
Route::post('/suspend/garage_service','GarageServicesController@suspend_garage_service');
Route::post('/restore/garage_service','GarageServicesController@restore_garage_service');

Route::get('/get_services_pricing_json','ServicesPricingController@get_services_pricing_json');
Route::post('/add/service_pricing','ServicesPricingController@add_service_pricing');
Route::post('/suspend/service_pricing','ServicesPricingController@suspend_service_pricing');
Route::post('/restore/service_pricing','ServicesPricingController@restore_service_pricing');

/*
 * Mechanics Routes
 */
Route::get('/mechanic/home','MechanicController@index')->name('mechanic_home');


/*
 * User Routes
 * */
Route::get('/get_requests_json','RequestsController@get_requests_json');
Route::post('/get_categories_json','RequestsController@get_categories_json');
Route::post('/get_services_json','RequestsController@get_services_json');
Route::post('/amount','RequestsController@fill_amount');
Route::post('/add/request','RequestsController@add_request');
Route::get('/test',function (){});
