<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->get('user', 'App\Api\V1\Controllers\UserController@index');
	$api->post('user/login', 'App\Api\V1\Controllers\UserController@login');
	$api->post('user/signup', 'App\Api\V1\Controllers\UserController@signup');
	$api->post('user/recovery', 'App\Api\V1\Controllers\UserController@recovery');
	$api->post('user/reset', 'App\Api\V1\Controllers\UserController@reset');


	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\User::all();
	}]);

	// example of free route
	$api->get('free', function() { 
		return \App\User::all();
	});

	$api->group(['middleware' => 'api.auth'], function ($api) {
		$api->post('products/store', 'App\Api\V1\Controllers\ProductController@store');
		$api->get('products', 'App\Api\V1\Controllers\ProductController@index');
		$api->get('products/{id}', 'App\Api\V1\Controllers\ProductController@show');
		$api->put('products/{id}', 'App\Api\V1\Controllers\ProductController@update');
		$api->delete('products/{id}', 'App\Api\V1\Controllers\ProductController@destroy');
	});

	$api->group(['middleware' => 'api.auth'], function ($api) {
		$api->post('orders/store', 'App\Api\V1\Controllers\OrderController@store');
		$api->get('orders', 'App\Api\V1\Controllers\OrderController@index');
		$api->get('orders/{id}', 'App\Api\V1\Controllers\OrderController@show');
		$api->put('orders/{id}', 'App\Api\V1\Controllers\OrderController@update');
		$api->delete('orders/{id}', 'App\Api\V1\Controllers\OrderController@destroy');
	});

	$api->group(['middleware' => 'api.auth'], function ($api) {
		$api->post('fooditems/store', 'App\Api\V1\Controllers\FoodItemsController@store');
		$api->get('fooditems', 'App\Api\V1\Controllers\FoodItemsController@index');
		$api->get('fooditems/{id}', 'App\Api\V1\Controllers\FoodItemsController@show');
		$api->put('fooditems/{id}', 'App\Api\V1\Controllers\FoodItemsController@update');
		$api->delete('fooditems/{id}', 'App\Api\V1\Controllers\FoodItemsController@destroy');
	});



});


