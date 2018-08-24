<?php

$router->group(['prefix' => 'schools', 'as' => 'schools'], function () use ($router) {
    $router->get('/', ['as' => 'index', 'uses' => 'SchoolsController@index']);
    $router->get('/{id}', ['as' => 'show', 'uses' => 'SchoolsController@show']);
    $router->post('/', ['as' => 'store', 'uses' => 'SchoolsController@store']);
    $router->put('/{id}', ['as' => 'update', 'uses' => 'SchoolsController@update']);
    $router->delete('/{id}', ['as' => 'update', 'uses' => 'SchoolsController@delete']);
});

$router->group(['prefix' => 'categories', 'as' => 'categories'], function () use ($router) {
    $router->get('/', ['as' => 'index', 'uses' => 'CategoriesController@index']);
});