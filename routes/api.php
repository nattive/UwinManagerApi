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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('signup', 'AuthController@signup');
    
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::group(['prefix' => 'checklist', 'middleware' => 'auth:api'], function () {
    Route::get('check', 'ChecklistController@shouldOpenDialog');
    Route::get('checkTime', 'ChecklistController@getTimeOfTheDay');
    Route::get('store', 'ChecklistController@store');
    Route::get('latest', 'ChecklistController@latest');
    
});

Route::group(['prefix' => 'report'], function () {
    Route::group(['prefix' => 'wskpa'], function () {
        Route::get('/', 'WSKPAController@index');
        Route::get('/Latest', 'WSKPAController@Latest');
        Route::post('store', 'WSKPAController@store');
        Route::post('show', 'WSKPAController@show');
        Route::patch('update', 'WSKPAController@update');
        Route::delete('destroy', 'WSKPAController@destroy');
    });
  Route::group(['prefix' => 'sfcr'], function () {
        Route::get('/', 'FuelConsumptionReportController@index');
        Route::get('/Latest', 'FuelConsumptionReportController@Latest');
        Route::post('store', 'FuelConsumptionReportController@store');
        Route::post('show', 'FuelConsumptionReportController@show');
        Route::patch('update', 'FuelConsumptionReportController@update');
        Route::delete('destroy', 'FuelConsumptionReportController@destroy');
    });


});

Route::group(['prefix' => 'report'], function () {
    Route::group(['prefix' => 'fuel'], function () {
        Route::get('/', 'FuelConsumptionReportController@index');
        Route::get('/getThisWeekReport', 'FuelConsumptionReportController@getThisWeekReport');
        Route::post('store', 'FuelConsumptionReportController@store');
        Route::post('show', 'FuelConsumptionReportController@show');
        Route::patch('update', 'FuelConsumptionReportController@update');
        Route::delete('destroy', 'FuelConsumptionReportController@destroy');
    });
});

Route::get('test', 'ChecklistController@shouldOpenDialog');
// $permissions = [
//     "View All Managers",
//     "Review Report",
//     "Create Manager's Forum",
//     "Accept request",
//     "Edit All Users",
//     "De;ete User",
//     "Assign Role",
//     "Unassign Role",
//     "View All Permissions",
//     "View All Roles"
// ];


Route::get('/permissions', 'RoleManagerController@permissionsIndex')
    ->name('permissions.index')
    ->middleware('permission:View All Permissions');

// Route::get('/roles', 'RoleManager@rolesIndex')
//     ->name('roles.index')
//     ->middleware('permission:View All Roles');

// Route::post('/roles/{role}/assign/{user}', 'RoleManager@rolesAddUser')
//     ->name('roles.addUser')
//     ->middleware('permission:Assign Role');

// Route::post('/roles/{role}/unassign/{user}', 'RoleManager@rolesRemoveUser')
//     ->name('roles.removeUser')
//     ->middleware('permission:Unassign Role');

//     Route::get('/check', 'ChecklistController@checkIfChecklistExist');
//     Route::post('/check/store', 'ChecklistController@store');
//     Route::post('/getTomeOfTheDay', 'ChecklistController@getTomeOfTheDay');