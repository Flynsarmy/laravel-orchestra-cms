<?php namespace Flynsarmy\OrchestraCms\Providers;

use App;
use File;
use Flynsarmy\OrchestraCms\Providers\Interfaces\ContentStorage;

class FileContentStorage implements ContentStorage {

    protected $theme;
    protected $rel_base_path;

    /**
     * Locates the folders on disk for content to be stored.
     *
     * @param string $theme
     * @param string $rel_base_path  A rel path prefix. Usually pages, partials or templates
     */
    public function __construct($theme, $rel_base_path = '')
    {
        $this->theme = $theme;
        $this->rel_base_path = $rel_base_path;
    }

    /**
     * Get the base path for content ot be stored.
     * e.g /APPPATH/themes/<theme>/packages/flynsarmy/orchestra-cms
     *
     * @return string
     */
    public function base_path()
    {
        return App::make('path.public') . '/themes/' . $this->theme . '/packages/flynsarmy/orchestra-cms';
    }

    /**
     * Get the path relative to base_path for content to be stored.
     * e.g pages/slug
     *
     * @param  string $slug
     *
     * @return string
     */
    public function rel_path( $slug )
    {
        return $this->rel_base_path . '/' . $slug;
    }

    /**
     * Same as rel_path but will suffix with -n where n is an incrementing
     * integer starting at 1 until a unique folder name is found.
     * e.g pages/slug-1
     *
     * @param  string $slug
     *
     * @return string
     */
    public function unique_rel_path( $slug )
    {
        $i = 0;
        $rel_path = $this->rel_path($slug);
        $unique_rel_path = $rel_path;

        while ( File::isDirectory($this->abs_path($unique_rel_path)) )
            $unique_rel_path = $rel_path . '-' . ++$i;


        return $unique_rel_path;
    }

    /**
     * Get the absolute filepath to our folder.
     * e.g abs_path()/rel_path()
     *
     *
     * @param  string $slug
     *
     * @return string
     */
    public function abs_path( $rel_path )
    {
        return $this->base_path() . '/' . $rel_path;
    }

    /**
     * Get the view path for rendering with View::make().
     * e.g flynsarmy/orchestra-cms::pages.slug
     *
     * @param  string $slug
     *
     * @return string
     */
    public function view_path( $rel_path )
    {
        return 'flynsarmy/orchestra-cms::' . str_replace('/', '.', $rel_path);
    }
}