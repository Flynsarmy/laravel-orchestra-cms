<?php

use \Config;
use \Event;
use \Route;
use \Artisan;
use Orchestra\Support\Facades\Resources;

/*
|--------------------------------------------------------------------------
| Frontend Controllers
|--------------------------------------------------------------------------
*/

Route::group(array(), function () {
    $page = Config::get('flynsarmy/orchestra-cms::permalink');

    Route::get($page, 'Flynsarmy\OrchestraCms\Controllers\Frontend\PageController@show');
    Route::get('/', 'Flynsarmy\OrchestraCms\Controllers\Frontend\PageController@show');
});

/*
|--------------------------------------------------------------------------
| Backend Controllers
|--------------------------------------------------------------------------
*/

Event::listen('orchestra.started: admin', function () {
    $story = Resources::make('orchestra-cms', array(
        'name'    => 'Orchestra CMS',
        'uses'    => 'restful:Flynsarmy\OrchestraCms\Controllers\Backend\HomeController',
        'visible' => Auth::check(),
    ));

    $story['pages'] = 'resource:Flynsarmy\OrchestraCms\Controllers\Backend\PageController';
    $story['templates'] = 'resource:Flynsarmy\OrchestraCms\Controllers\Backend\TemplateController';
    $story['partials'] = 'resource:Flynsarmy\OrchestraCms\Controllers\Backend\PartialController';
});