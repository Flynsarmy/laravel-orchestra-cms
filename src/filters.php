<?php

use \Event;
use \Route;
use Orchestra\Support\Facades\Acl;
use Flynsarmy\OrchestraCms\Facades\StoryFormat;

/*
|--------------------------------------------------------------------------
| Fire Event based on Format
|--------------------------------------------------------------------------
|
| Fire an event for selected editing format.
|
*/

Route::filter('orchestra.story.editor', function ($request, $route, $format = '') {
    Event::fire("orchestra.story.editor: {$format}");
});

/*
|--------------------------------------------------------------------------
| Filter Content Management
|--------------------------------------------------------------------------
|
| Filter if user can execute certain task to a post/page, e.g: edit a post.
|
*/

Route::filter('orchestra.story', function ($request, $route, $value = '') {
    list($action, $type) = explode('-', $value);

    $acl = Acl::make('flynsarmy/orchestra-cms');

    if (! ($acl->can("{$action} {$type}") or $acl->can("manage {$type}"))) {
        return Redirect::to(resources("orchestra-cms.{$type}s"));
    }
});
