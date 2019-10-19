<?php
	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register all of the routes for an application.
	| It is a breeze. Simply tell Lumen the URIs it should respond to
	| and give it the Closure to call when that URI is requested.
	|
	*/
	$router->get('/', function() use ($router){
		return $router->app->version();
	});
	$router->post('/login/user', 'LoginController@user');
    $router->post('/register/user', 'RegisterController@user');

    $router->get('/navigation', 'NavigationController@navigation');

	$router->group(['middleware' => 'auth'], function() use ($router){
		$router->post('/user/todo/select', 'TodoController@select');
		$router->post('/user/todo/view', 'TodoController@view');
		$router->post('/user/todo/add', 'TodoController@add');
		$router->post('/user/todo/edit', 'TodoController@edit');
		$router->post('/user/todo/delete', 'TodoController@delete');
		$router->post('/user/todo/autocomplete', 'TodoController@autocomplete');

        $router->post('/user/view', 'UserController@view');
	});
