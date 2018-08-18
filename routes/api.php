<?php

$router->group(['prefix' => 'schools', 'as' => 'schools'], function () use ($router) {
    $router->get('/', ['as' => 'index', 'uses' => 'SchoolsController@index']);
});

$router->group(['prefix' => 'categories', 'as' => 'categories'], function () use ($router) {
    $router->get('/', ['as' => 'index', 'uses' => 'CategoriesController@index']);
});

$router->group(['prefix' => 'cities', 'as' => 'cities'], function () use ($router) {
    $router->get('/', ['as' => 'index', 'uses' => 'CitiesController@index']);
});