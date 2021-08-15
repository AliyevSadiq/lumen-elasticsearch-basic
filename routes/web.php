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

//$router->get('/', function () use ($router) {
//    return response()->json(true,200);
//});

$router->group(['name' => 'articles.', 'prefix' => 'api/articles'], function () use ($router) {
    $router->get('/', 'ArticleController@index');
    $router->get('/search', 'ArticleController@search');
    $router->post('/', 'ArticleController@store');
    $router->get('/{id}', 'ArticleController@edit');
    $router->delete('/{id}', 'ArticleController@delete');
//    $router->put('/','ArticleController@store');
});
