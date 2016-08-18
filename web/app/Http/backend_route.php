<?php
/**
 * @Author: Lich
 * @Date:   2016-07-17 14:36:23
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-08-18 16:21:01
 */

///////////////////
// Backend route //
///////////////////
Route::group([
	'middleware' => 'admin',
	'prefix' => 'admin',
	'as' => 'admin.'
], function() {
	////////////////////////
	// Authenticate route //
	////////////////////////
	Route::get('/login', [
		'as' => 'login',
		'uses' => 'Auth\AuthController@showLoginForm'
	]);
	Route::post('/login', [
		'as' => 'login',
		'uses' => 'Auth\AuthController@login'
	]);
	Route::get('/logout', [
		'as' => 'logout',
		'uses' => 'Auth\AuthController@logout'
	]);
	Route::get('/password/email', [
		'as' => 'password.email',
		'uses' => 'Auth\PasswordController@getEmail'
	]);
	Route::post('/password/email', [
		'as' => 'password.email',
		'uses' => 'Auth\PasswordController@sendResetLinkEmail'
	]);
	Route::get('/password/reset/{token}', [
		'as' => 'password.reset',
		'uses' => 'Auth\PasswordController@showResetForm'
	]);
	Route::post('/password/reset', [
		'as' => 'password.reset',
		'uses' => 'Auth\PasswordController@reset'
	]);
	Route::group(['middleware' => 'admin.auth'], function(){
		Route::get('/', [
			'as' => 'home',
			'uses' => 'HomeController@index'
		]);
		Route::get('/profile', [
			'as' => 'profile',
			'uses' => 'HomeController@getProfile'
		]);
		Route::post('/profile', [
			'as' => 'profile',
			'uses' => 'HomeController@postProfile'
		]);
		////////////////
		// User route //
		////////////////
		Route::group([
			'prefix' => 'users',
			'as' => 'users.'
		], function() {
			Route::get('/add', [
				'as' => 'add',
				'uses' => 'UserController@add'
			]);
			Route::post('/store', [
				'as' => 'store',
				'uses' => 'UserController@store'
			]);
		});
		////////////////
		// Role route //
		////////////////
		Route::group([
			'prefix' => 'roles',
			'as' => 'roles.'
		], function () {
			Route::get('/', [
				'as' => 'index',
				'uses' => 'RoleController@index'
			]);
			Route::get('/list-as-json', [
				'as' => 'list_as_json',
				'uses' => 'RoleController@getRoleListAsJson'
			]);
			Route::get('/view/{id}', [
				'as' => 'view',
				'uses' => 'RoleController@getView'
			]);
			Route::get('/add', [
				'as' => 'add',
				'uses' => 'RoleController@getAdd'
			]);
			Route::post('/store', [
				'as' => 'store',
				'uses' => 'RoleController@postAdd'
			]);
			Route::get('/edit/{id}', [
				'as' => 'edit',
				'uses' => 'RoleController@getEdit'
			]);
			Route::post('/update/{id}', [
				'as' => 'update',
				'uses' => 'RoleController@postEdit'
			]);
			Route::post('/delete/{id}', [
				'as' => 'delete',
				'uses' => 'RoleController@postDelete'
			]);
			Route::post('/delete-selected', [
				'as' => 'delete_selected',
				'uses' => 'RoleController@postDeleteSelected'
			]);
		});
		////////////////
		// Permission route //
		////////////////
		Route::group([
			'prefix' => 'permissions',
			'as' => 'permissions.'
		], function () {
			Route::get('/', [
				'as' => 'index',
				'uses' => 'PermissionController@index'
			]);
			Route::get('/list-as-json', [
				'as' => 'list_as_json',
				'uses' => 'PermissionController@getPermissionListAsJson'
			]);
			Route::get('/view/{id}', [
				'as' => 'view',
				'uses' => 'PermissionController@getView'
			]);
			Route::get('/add', [
				'as' => 'add',
				'uses' => 'PermissionController@getAdd'
			]);
			Route::post('/store', [
				'as' => 'store',
				'uses' => 'PermissionController@postAdd'
			]);
			Route::get('/edit/{id}', [
				'as' => 'edit',
				'uses' => 'PermissionController@getEdit'
			]);
			Route::post('/update/{id}', [
				'as' => 'update',
				'uses' => 'PermissionController@postEdit'
			]);
			Route::post('/delete/{id}', [
				'as' => 'delete',
				'uses' => 'PermissionController@postDelete'
			]);
			Route::post('/delete-selected', [
				'as' => 'delete_selected',
				'uses' => 'PermissionController@postDeleteSelected'
			]);
		});

		//////////////////////
		// Admin user route //
		//////////////////////
		Route::group([
			'prefix' => 'admin-users',
			'as' => 'admin_users.'
		], function () {
			Route::get('/', [
				'as' => 'index',
				'uses' => 'AdminUserController@index'
			]);
			Route::get('/list-as-json', [
				'as' => 'list_as_json',
				'uses' => 'AdminUserController@getAdminUserListAsJson'
			]);
			Route::get('/view/{id}', [
				'as' => 'view',
				'uses' => 'AdminUserController@getView'
			]);
			Route::get('/add', [
				'as' => 'add',
				'uses' => 'AdminUserController@getAdd'
			]);
			Route::post('/store', [
				'as' => 'store',
				'uses' => 'AdminUserController@postAdd'
			]);
			Route::get('/edit/{id}', [
				'as' => 'edit',
				'uses' => 'AdminUserController@getEdit'
			]);
			Route::post('/update/{id}', [
				'as' => 'update',
				'uses' => 'AdminUserController@postEdit'
			]);
			Route::post('/delete/{id}', [
				'as' => 'delete',
				'uses' => 'AdminUserController@postDelete'
			]);
			Route::post('/delete-selected', [
				'as' => 'delete_selected',
				'uses' => 'AdminUserController@postDeleteSelected'
			]);
		});

		//////////////////////
		// Log route //
		//////////////////////
		Route::group([
			'prefix' => 'logs',
			'as' => 'logs.'
		], function () {
			Route::match(['get', 'post'], '/', [
				'as' => 'index',
				'uses' => 'LogController@index'
			]);
		});

		//////////////////////
		// Admin user route //
		//////////////////////
		Route::group([
			'prefix' => 'locations',
			'as' => 'locations.'
		], function () {
			Route::get('/', [
				'as' => 'index',
				'uses' => 'LocationController@index'
			]);
			Route::get('/list-as-json', [
				'as' => 'list_as_json',
				'uses' => 'LocationController@getLocationListAsJson'
			]);
			Route::get('/view/{id}', [
				'as' => 'view',
				'uses' => 'LocationController@getView'
			]);
			Route::get('/add', [
				'as' => 'add',
				'uses' => 'LocationController@getAdd'
			]);
			Route::post('/store', [
				'as' => 'store',
				'uses' => 'LocationController@postAdd'
			]);
			Route::get('/edit/{id}', [
				'as' => 'edit',
				'uses' => 'LocationController@getEdit'
			]);
			Route::post('/update/{id}', [
				'as' => 'update',
				'uses' => 'LocationController@postEdit'
			]);
			Route::post('/delete/{id}', [
				'as' => 'delete',
				'uses' => 'LocationController@postDelete'
			]);
			Route::post('/delete-selected', [
				'as' => 'delete_selected',
				'uses' => 'LocationController@postDeleteSelected'
			]);
		});

		//////////////////////
		// Bus trip route //
		//////////////////////
		Route::group([
			'prefix' => 'bus-trips',
			'as' => 'bus_trips.'
		], function () {
			Route::get('/', [
				'as' => 'index',
				'uses' => 'BusTripController@index'
			]);
			Route::get('/list-as-json', [
				'as' => 'list_as_json',
				'uses' => 'BusTripController@getBusTripListAsJson'
			]);
			// Route::get('/view/{id}', [
			// 	'as' => 'view',
			// 	'uses' => 'BusTripController@getView'
			// ]);
			// Route::get('/add', [
			// 	'as' => 'add',
			// 	'uses' => 'BusTripController@getAdd'
			// ]);
			// Route::post('/store', [
			// 	'as' => 'store',
			// 	'uses' => 'BusTripController@postAdd'
			// ]);
			// Route::get('/edit/{id}', [
			// 	'as' => 'edit',
			// 	'uses' => 'BusTripController@getEdit'
			// ]);
			// Route::post('/update/{id}', [
			// 	'as' => 'update',
			// 	'uses' => 'BusTripController@postEdit'
			// ]);
			// Route::post('/delete/{id}', [
			// 	'as' => 'delete',
			// 	'uses' => 'BusTripController@postDelete'
			// ]);
			// Route::post('/delete-selected', [
			// 	'as' => 'delete_selected',
			// 	'uses' => 'BusTripController@postDeleteSelected'
			// ]);
		});
	});
});
