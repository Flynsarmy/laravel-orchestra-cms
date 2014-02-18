<?php namespace Flynsarmy\OrchestraCms;

use Carbon\Carbon;
use Flynsarmy\OrchestraCms\Model\Content;

class Storyteller
{
    /**
     * Application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Create a new instance of Storytelling.
     *
     * @param  \Illuminate\Foundation\Application   $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Generate URL by content.
     *
     * @param  Model
     */
    public function permalink($content = null)
    {
        $format = $this->app['config']->get("flynsarmy/orchestra-cms::permalink", '{slugz}');

        $permalinks = array(
            'id'    => $content->id,
            'slug'  => ltrim($content->slug, '/')
        );

        foreach ($permalinks as $key => $value) {
            $format = str_replace('{'.$key.'}', $value, $format);
        }

        return handles("flynsarmy/orchestra-cms::/{$format}");
    }
}
