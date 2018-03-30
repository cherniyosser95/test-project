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
    return view('index');
});
Route::group(['prefix' => 'Roles'], function () {
// Route to create a new role
    Route::post('Create', 'RolesController@createRole');
//Route to edit role
    Route::post('Edit/{id}', 'RolesController@EditRole');
//Route to delete
    Route::post('Delete/{id}', 'RolesController@DeleteRole');
//Route to get all roles
    Route::get('All-Roles', 'RolesController@GetRoles');
//Route to get Role By Id
    Route::get('GetRoleById', 'RolesController@GetRoleById');

});
Route::group(['prefix' => 'Permissions'], function () {
// Route to create a new permission
    Route::post('Create-Permission', 'PermessionsController@createPermission');
Route::post('Edit-Permission/{id}', 'PermessionsController@EditPermission');
    Route::post('Delete-Permission/{id}', 'PermessionsController@DeletePermission');

});
Route::group(['prefix' => 'Roles-Users'], function () {
// Route to assign role to user
    Route::post('Create-assign-role', 'RolesController@assignRole');
// Route to edit assign role
    Route::post('Edit-assign-role/{id_user}/{id_role}', 'RolesController@EditAttachedRole');
//delete assigned role
    Route::post('Delete-assign-role/{id}', 'RolesController@Destroy',['middleware' => 'jwt.auth']);



});
Route::group(['prefix' => 'Permissions-Roles',['middleware' => 'jwt.auth']], function () {
// Route to attache permission to a role
    Route::post('attach-permission', 'PermessionsController@attachPermission',['middleware' => 'jwt.auth']);
});
// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    // Protected route
    Route::get('users', 'JwtAuthenticateController@index',['middleware' => 'jwt.auth']);
});

// Authentication route
Route::post('authenticate', 'JwtAuthenticateController@authenticate',['middleware' => 'jwt.auth']);

Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    Route::get('users', 'JwtAuthenticateController@index');

});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api',['middleware' => 'jwt.auth']], function () {

    Route::post('/auth/register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);


});

Route::get('user', 'JwtAuthenticateController@getAuthUser',['middleware' => 'jwt.auth']);