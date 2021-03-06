
<?php

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
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login')->name('login');

    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['prefix' => 'checklist', 'middleware' => ['auth:api']], function () {
    Route::get('check', 'ChecklistController@shouldOpenDialog');
    Route::get('checkTime', 'ChecklistController@getTimeOfTheDay');
    Route::get('store', 'ChecklistController@store');
    Route::get('latest', 'ChecklistController@latest');
});

Route::group(['prefix' => 'notification', 'middleware' => ['auth:api']], function () {
    Route::post('/', 'NotifyUserController@store');
    Route::delete('/', 'NotifyUserController@destroy');
    Route::put('/read/{id}', 'NotifyUserController@read');
});
Route::group(['prefix' => 'users', 'middleware' => ['auth:api']], function () {
    Route::get('active/all', 'UserController@active');
    Route::get('get/{id}', 'UserController@show');
    Route::post('update/{id}', 'UserController@update');
    Route::post('update/{id}', 'UserController@update');
});

Route::group(['prefix' => 'chat', 'middleware' => ['auth:api']], function () {
    Route::get('messages', 'ChatController@fetchMessages');
    Route::get('read/{id}', 'ChatController@readMessage');
    Route::get('online/all', 'ChatController@getOnlineManagers');
    Route::get('messages/chat-id/{id}', 'ChatController@getMessagesByChat');
    Route::post('messages', 'ChatController@sendMessage');
    Route::post('/private/init', 'ChatController@InitSingleChat');
    Route::get('/private', 'ChatController@getChat');
    Route::get('/all', 'ChatController@getAllChat');
    // Route::get('group/all', 'GroupController@myGroup');

    Route::group(['prefix' => 'group', 'middleware' => ['auth:api']], function () {
        Route::get('/init/{id}', 'GroupController@init');
        Route::post('/store', 'GroupController@store');
        Route::get('/get_messages/{id}', 'GroupController@getChat');
        Route::post('/addUser', 'GroupController@addUser');
        Route::post('/groupChat', 'GroupController@groupChat');
        Route::get('/myGroup', 'GroupController@myGroup');
        Route::post('/update/{group_id}', 'GroupController@update');
    });
});


Route::group(['prefix' => 'supervisor'], function () {

    Route::group(['prefix' => 'user', 'middleware' => ['isDirector']], function () {
        Route::get('all', 'UserController@all');
    Route::post('signup', 'AuthController@signup');

    });
    Route::group(['prefix' => 'roles', 'middleware' => ['auth:api', 'isDirector' ]], function () {
        Route::post('/assign', 'PositionController@assign');
        Route::post('/default', 'PositionController@toDefault');

    });
    Route::group(['prefix' => 'report', 'middleware' => ['auth:api',  'isSupervisor']], function () {
        Route::post('/approve', 'SupervisorController@approveReport');
        Route::get('/wskpa', 'SupervisorController@wskpa');
        Route::get('/sfcr', 'SupervisorController@sfcr');
        Route::get('/sales', 'SupervisorController@sales');
        Route::get('/wskpa/{id}', 'SupervisorController@wskpaByUser');
        Route::get('/sfcr/{id}', 'SupervisorController@sfcrByUser');
        Route::get('/sales/{id}', 'SupervisorController@salesByUser');
        Route::get('/checklist', 'SupervisorController@checklist');
        Route::get('/checklist/{id}', 'SupervisorController@UserChecklist');
    });

    Route::group(['prefix' => 'permission', 'middleware' => ['auth:api',  'isSupervisor']], function () {
        Route::post('/list', 'PermissionController@permission_list');
        Route::delete('/user/delete/{id}', 'UserController@destroy');
        Route::post('/store', 'PermissionController@permission_store');
        Route::post('/permit_role/{role}', 'PermissionController@givePermissionToRole');

    });
});

Route::group(['prefix' => 'report', 'middleware' => ['auth:api']], function () {
    Route::get('all/Latest', 'ReportController@index');
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
    Route::group(['prefix' => 'sales'], function () {
        Route::get('/', 'AccountReportController@index');
        Route::post('store', 'AccountReportController@store');
        Route::get('show/{id}', 'AccountReportController@show');
        Route::patch('update', 'AccountReportController@update');
        Route::delete('destroy', 'AccountReportController@destroy');
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

// Route::get('/permissions', 'RoleManagerController@permissionsIndex')
//     ->name('permissions.index')
//     ->middleware('permission:View All Permissions');

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
