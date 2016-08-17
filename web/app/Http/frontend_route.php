<?php
/**
 * @Author: Lich
 * @Date:   2016-07-17 14:36:36
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-07-22 13:25:39
 */
Route::group(['middleware' => 'web'], function(){
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
	Route::get('/register', [
		'as' => 'register',
		'uses' => 'Auth\AuthController@showRegistrationForm'
	]);
	Route::post('/register', [
		'as' => 'register',
		'uses' => 'Auth\AuthController@register'
	]);
	Route::group(['middleware' => 'auth'], function(){
		Route::get('/', [
			'as' => 'home',
			'uses' => 'HomeController@index'
		]);
	});
});