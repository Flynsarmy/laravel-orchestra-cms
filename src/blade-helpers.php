<?php

use Flynsarmy\OrchestraCms\Exceptions\PartialNotFoundException;
use Flynsarmy\OrchestraCms\Models\Partial;

/**
 * Add @partial('foo') command. Same syntax as @include
 * http://blog.zerilliworks.net/blog/2013/07/10/blade-extensions-in-laravel-4/
 */
Blade::extend(function($blade_string) {
    $one = 1;
    $pattern = '/(?<!\w)(\s*)@partial\(\s*[\'\"]([^\'\"]*)[\'\"](.*)\)/';
    $replace = '%1$s<?php echo $__env->make(\'%2$s\'%3$s, array_except(get_defined_vars(), array(\'__data\', \'__path\')))->render(); ?>';

    preg_match_all($pattern, $blade_string, $matches);

    foreach ( $matches[0] as $key => $from )
    {
        $title = $matches[2][$key];
        $partial = Partial::where('title', '=', $title)->first();

        if ( !$partial )
            throw new PartialNotFoundException("Partial '{$title}' not found.");

        if ( $partial )
        {
            $view = $partial->storage()->view_path('content');
            $to = sprintf($replace, $matches[1][$key], $view, $matches[3][$key]);
        }
        else
            $to = '';

        $blade_string = str_replace($from, $to, $blade_string, $one);
    }

    return $blade_string;
});

Blade::extend(function($blade_string) {
    $replace = '<?php echo $__env->make($page->storage()->view_path(\'content\'), array_except(get_defined_vars(), array(\'__data\', \'__path\')))->render(); ?>';
    return str_replace('@page()', $replace, $blade_string);
});