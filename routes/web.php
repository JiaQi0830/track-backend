<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'processes'], function () use ($router) {
        $router->get('/', 'ProcessController@getProcess');
        $router->post('/', 'ProcessController@storeProcess');
    });

    $router->group(['prefix' => 'jobs'], function () use ($router) {
        $router->get('/', 'JobController@getJob');
        $router->get('/{jobId}/processes', 'JobController@getJobProcess');
        $router->post('/', 'JobController@storeJob');
        $router->put('/{jobId}', 'JobController@editJob');
        $router->put('/{jobId}/{processId}/complete', 'JobController@completeProcess');
        $router->put('/{jobId}/{processId}/remark', 'JobController@remarkProcess');
    });

});
