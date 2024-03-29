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
})->name('main');

Route::group(['middleware' => ['web']], function () {
    // Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

    // Password Reset Routes...
    Route::get(
        'password/reset',
        ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']
    );
    Route::post(
        'password/email',
        ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']
    );
    Route::get(
        'password/reset/{token}',
        ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']
    );
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('manager', ['as' => 'manager', 'uses' => 'ManagerController@index']);
    Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@index']);

    Route::get(
        'manager/company-meta',
        ['as' => 'manager.company.meta', 'uses' => 'ManagerController@renderCompanyMeta']
    );

    Route::post('profile', ['as' => 'profile.save', 'uses' => 'ProfileController@save']);
});

Route::group(['middleware' => ['auth', 'manage.image']], function () {
    Route::post('api/image', ['as' => 'image.upload', 'uses' => 'UploadController@uploadImage']);
    Route::delete('api/image', ['as' => 'image.delete', 'uses' => 'UploadController@deleteImage']);
});

Route::group(['middleware' => ['auth', 'manage.company.meta']], function () {
    Route::get(
        'manager/getCompanyMeta',
        ['as' => 'manager.get.company.meta', 'uses' => 'ManagerController@getCompanyMeta']
    );
    Route::post(
        'manager/saveCompanyMeta',
        ['as' => 'manager.save.company.meta', 'uses' => 'ManagerController@saveCompanyMeta']
    );
});
Route::group(['middleware' => ['auth', 'manage.users']], function () {
    Route::get('manager/users', ['as' => 'manager.users', 'uses' => 'ManagerController@renderUsers']);
    Route::post(
        'manager/user/save',
        ['as' => 'manager.user.save', 'uses' => 'ManagerController@saveUser']
    );
    Route::post(
        'manager/role/save',
        ['as' => 'manager.role.save', 'uses' => 'ManagerController@saveRole']
    );
    Route::get(
        'manager/role/permissions',
        ['as' => 'get.role.permissions', 'uses' => 'ManagerController@getRolePermissions']
    );
    Route::post(
        'manager/role/create',
        ['as' => 'manager.role.create', 'uses' => 'ManagerController@createRole']
    );

    Route::post(
        'manager/role/delete',
        ['as' => 'manager.role.delete', 'uses' => 'ManagerController@deleteRole']
    );
    // REST
    Route::get('api/permissions', ['as' => 'get.all.permissions', 'uses' => 'PermissionController@getAll']);

    Route::post('api/permission/{id}', ['as' => 'save.permission', 'uses' => 'PermissionController@save']);
    Route::put('api/permissions', ['as' => 'add.permission', 'uses' => 'PermissionController@add']);
    Route::delete('api/permissions/{id}', ['as' => 'delete.permission', 'uses' => 'PermissionController@delete']);

    Route::get('api/users', ['as' => 'get.users', 'uses' => 'UserController@getAll']);
    Route::get('api/roles', ['as' => 'get.roles', 'uses' => 'RoleController@getAll']);
});
