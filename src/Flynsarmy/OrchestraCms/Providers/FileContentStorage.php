<?php namespace Flynsarmy\OrchestraCms\Providers;

use App;
use File;
use Str;
use Illuminate\Database\Eloquent\Model;
use Flynsarmy\OrchestraCms\Providers\Interfaces\ContentStorage;

class FileContentStorage implements ContentStorage {

    protected $theme;
    protected $model;

    /**
     * Locates the folders on disk for content to be stored.
     *
     * @param Model  $model
     * @param string $theme
     */
    public function __construct(Model $model, $theme)
    {
        $this->model = $model;
        $this->theme = $theme;
    }

    /**
     * Get the base path for content ot be stored.
     *
     * @return string   e.g /APPPATH/themes/<theme>/packages/flynsarmy/orchestra-cms
     */
    public function theme_path()
    {
        return App::make('path.public') . '/themes/' . $this->theme . '/packages/flynsarmy/orchestra-cms';
    }

    /**
     * Determine the folder in our theme path all views for this content type
     * will go into
     *
     * @return string   Usually templates, pages or partials
     */
    public function content_type_dir()
    {
        // Strip namespace
        $class_path = explode('\\', get_class($this->model));
        $class_name = end($class_path);

        return Str::plural(strtolower($class_name));
    }

    /**
     * Get the path relative to content type path for content to be stored.
     * This is taken from the model and should already be set.
     *
     * @return string   e.g contact-us
     */
    public function content_dir()
    {
        return $this->model->content_dir;
    }

    /**
     * Same as content_dir but will suffix with -n where n is an incrementing
     * integer starting at 1 until a unique folder name is found.
     *
     * @return string   e.g contact-us-1
     */
    public function unique_content_dir()
    {
        $content_dir = Str::slug($this->model->title);
        $unique_content_dir = $content_dir;

        $i = 0;
        while ( File::isDirectory($this->rel_dir().'/'.$unique_content_dir) )
            $unique_content_dir = $content_dir . '-' . ++$i;


        return $unique_content_dir;
    }

    /**
     * Returns the directory all pages/partials/templates will be created
     * in for this model instance.
     *
     * @return string   e.g pages/contact-us
     */
    public function rel_dir()
    {
        return
            $this->content_type_dir().'/'.
            $this->content_dir();
    }

    /**
     * Returns path to a file relative to the theme path
     *
     * @param  string $file_path e.g content
     *
     * @return string            e.g pages/contact-us/content
     */
    public function rel_path( $file_path )
    {
        return
            $this->rel_dir().'/'.
            $file_path;
    }

    /**
     * Get the absolute filepath to our folder.
     *
     * @param  string $file_path    e.g content
     *
     * @return string   e.g /path/to/pages/content
     */
    public function abs_path( $file_path )
    {
        return
            $this->theme_path().'/'.
            $this->rel_path( $file_path );
    }

    /**
     * Get the view path for rendering with View::make().
     *
     * @param  string $file_path    e.g content
     *
     * @return string   e.g flynsarmy/orchestra-cms::pages.content
     */
    public function view_path( $file_path )
    {
        $rel_path = $this->rel_path( $file_path );

        return 'flynsarmy/orchestra-cms::' . str_replace('/', '.', $rel_path);
    }
}