<?php

use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Attach Memory to ACL
|--------------------------------------------------------------------------
*/

Acl::make('flynsarmy/orchestra-cms')->attach(App::memory());

/*
|--------------------------------------------------------------------------
| Allow Configuration to be managed via Database
|--------------------------------------------------------------------------
*/

// Config::map('flynsarmy/orchestra-cms', array(
//     'permalink' => 'flynsarmy/orchestra-cms::config.permalink',
//     'default_template_content_view' => 'flynsarmy/orchestra-cms::config.default_template_content_view',
// ));