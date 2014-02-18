<?php namespace Flynsarmy\OrchestraCms\Models;

use App;
use File;
use Config;
use Str;
use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Flynsarmy\OrchestraCms\Facades\Story;
use Orchestra\Theme;

class CmsModel extends Eloquent
{
    protected $content_string = null;

    /**
     * Belongs to relationship with User.
     */
    public function author()
    {
        return $this->belongsTo(Config::get('auth.model', 'User'), 'user_id');
    }

    /**
     * Restrict scope to only this theme
     */
    public function scopeTheme($query)
    {
        $query->where('theme', '=', Theme::getTheme());
    }

    /**
     * Setter content.
     *
     * @return void
     */
    public function setContentAttribute($value)
    {
        $this->content_string = $value;
    }

    /**
     * Accessor for content.
     *
     * @return string
     */
    public function getContentAttribute($value)
    {
        if ( $this->content_string === null )
        {
            if ( $this->content_path )
                try {
                    $filepath = $this->getAbsContentBasePath( $this->theme ) . '/' . $this->content_path . '/content.blade.php';
                    $this->content_string = File::get($filepath);
                }
                catch (FileNotFoundException $e) {
                    $this->content_string = '';
                }
            else
                $this->content_string = '';
        }

        return $this->content_string;
    }

    public function getViewPath()
    {
        return 'flynsarmy/orchestra-cms::' . str_replace('/', '.', $this->content_path);
    }

    public function getAbsContentBasePath( $theme )
    {
        if ( !$theme )
            $theme = Theme::getTheme();

        return App::make('path.public') . '/themes/' . $theme . '/packages/flynsarmy/orchestra-cms';
    }

    /**
     * Returns a unique pages/<slug>/content.blade.php
     *
     * @return string
     */
    public function getOrSetRelContentPath()
    {
        $type_dir = strtolower(str_plural(class_basename(get_class($this))));
        $base_path = $this->getAbsContentBasePath( $this->theme );

        if ( empty($this->content_path) )
        {
            $i = 1;
            $relpath = "{$type_dir}/" . Str::slug($this->title);
            $abspath = "{$base_path}/{$relpath}";

            if ( File::isDirectory($abspath) )
            {
                while ( File::isDirectory($abspath.'-'.$i) )
                    $i++;

                $relpath .= '-' . $i;
            }

            $this->content_path = $relpath;
        }

        return $this->content_path;
    }

    /**
     * Export with content
     * http://stackoverflow.com/a/19088571/309083
     *
     * @return string JSON export
     */
    public function export()
    {
        $this->appends[] = 'content';
        return $this->toJson();
    }
}
