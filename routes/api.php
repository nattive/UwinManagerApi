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
    Route::get('check', 'ChecklistController@isExist');
    Route::get('checkTime', 'ChecklistController@getTimeOfTheDay');
    Route::get('store', 'ChecklistController@store');
    
});
Route::get('test', 'ChecklistController@test');
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