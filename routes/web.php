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

// Route to create a new role
Route::post('Create', 'JwtAuthenticateController@createRole');
//Route to edit role
Route::post('Edit/{id}', 'JwtAuthenticateController@EditRole');
//Route to delete
Route::post('Delete/{id}', 'JwtAuthenticateController@DeleteRole');
//Route to get all roles
Route::get('All-Roles', 'JwtAuthenticateController@GetRoles');



// Route to create a new permission
Route::post('permission', 'JwtAuthenticateController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'JwtAuthenticateController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    // Protected route
    Route::get('users', 'JwtAuthenticateController@index');
});

// Authentication route
Route::post('authenticate', 'JwtAuthenticateController@authenticate');

Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    Route::get('users', 'JwtAuthenticateController@index');

});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api'], function () {

    Route::post('/auth/register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);


});

Route::get('user', 'JwtAuthenticateController@getAuthUser',['middleware' => 'jwt.auth']);