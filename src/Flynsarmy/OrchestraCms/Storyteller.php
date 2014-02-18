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
     * Slugify a string - remove spaces,
     *
     * @param  string $text
     * @return string
     */
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if ( empty($text) )
            return 'n-a';

        return $text;
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
