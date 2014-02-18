<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Asset;
use Orchestra\Support\Facades\Widget;
use Flynsarmy\OrchestraCms\Models\Template;
use Flynsarmy\OrchestraCms\Models\Page;
use Flynsarmy\OrchestraCms\Models\Partial;
use Flynsarmy\OrchestraCms\Models\Observers\TemplateObserver;
use Flynsarmy\OrchestraCms\Models\Observers\PageObserver;
use Flynsarmy\OrchestraCms\Models\Observers\PartialObserver;

Template::observe(new TemplateObserver);
Page::observe(new PageObserver);
Partial::observe(new PartialObserver);

/*
|--------------------------------------------------------------------------
| Attach multiple widget for Story CMS
|--------------------------------------------------------------------------
*/

// View::composer('orchestra/foundation::dashboard.index', 'Flynsarmy\OrchestraCms\Events\DashboardHandler@onDashboardView');

Event::listen('orchestra.form: extension.flynsarmy/orchestra-cms', function () {
    $placeholder = Widget::make('placeholder.orchestra.extensions');
    $placeholder->add('permalink')->value(View::make('flynsarmy/orchestra-cms::backend.widgets.help'));
});

/*
|--------------------------------------------------------------------------
| Attach Configuration Callback
|--------------------------------------------------------------------------
*/

Event::listen('orchestra.form: extension.flynsarmy/orchestra-cms', 'Flynsarmy\OrchestraCms\Events\ExtensionHandler@onFormView');
Event::listen('orchestra.validate: extension.flynsarmy/orchestra-cms', function (& $rules) {
    $rules['permalink'] = array('required');
});

/*
|--------------------------------------------------------------------------
| Add asset for Markdown Editing
|--------------------------------------------------------------------------
|
| Load asset based on for markdown.
|
*/

Event::listen('orchestra.story.editor: ace', function () {
    $asset = Asset::container('orchestra/foundation::footer');
    $asset->script('editor', 'packages/flynsarmy/orchestra-cms/vendor/ace-builds/src-min-noconflict/ace.js');
    $asset->script('orchestra-cms', 'packages/flynsarmy/orchestra-cms/js/orchestra-cms.js');
    $asset->style( 'orchestra-cms.editor', 'packages/flynsarmy/orchestra-cms/css/orchestra-cms.css');
    $asset->style( 'orchestra-cms.editor.ace', 'packages/flynsarmy/orchestra-cms/css/orchestra-cms.ace.css');
    $asset->script('orchestra-cms.editor.ace', 'packages/flynsarmy/orchestra-cms/js/orchestra-cms.ace.js', array('editor'));
});