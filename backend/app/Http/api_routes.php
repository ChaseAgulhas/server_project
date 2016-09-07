<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');


	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\User::all();
	}]);

	// example of free route
	$api->get('free', function() {
		return \App\User::all();
	});

	$api->group(['middleware' => 'api.auth'], function ($api) {
		$api->get('books', 'App\Api\V1\Controllers\BookController@index');
		$api->get('books/{id}', 'App\Api\V1\Controllers\BookController@show');
		$api->post('books/store', 'App\Api\V1\Controllers\BookController@store');
		$api->put('books/{id}', 'App\Api\V1\Controllers\BookController@update');
		$api->delete('books/{id}', 'App\Api\V1\Controllers\BookController@destroy');
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

});


