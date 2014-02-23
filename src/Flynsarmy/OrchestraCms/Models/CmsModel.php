<?php namespace Flynsarmy\OrchestraCms\Models;

use App;
use File;
use Config;
use Str;
use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Flynsarmy\OrchestraCms\Facades\Story;
use Flynsarmy\OrchestraCms\Providers\FileContentStorage;
use Orchestra\Theme;

class CmsModel extends Eloquent
{
    protected $guarded = ['created_at', 'content_dir'];

    /**
     * The folder in our public theme directory all views will be saved into
     *
     * @var string
     */
    protected $view_base_path = '';

    protected $content_string = null;

    private $_storage_provider;

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
        // content_string will be null on first lookup - grab from the view file
        // if it exists
        if ( $this->content_string === null )
        {
            // View file exists. Grab contents
            if ( $this->content_dir )
                try {
                    $file_path = $this->storage()->abs_path('content.blade.php');

                    $this->content_string = File::get( $file_path );
                }
                catch (FileNotFoundException $e) {
                    $this->content_string = '';
                }
            // No view file exists - this is probably a new record. Set the
            // content to an empty string
            else
                $this->content_string = '';
        }

        return $this->content_string;
    }

    /**
     * Sets up and returns our content storage provider
     *
     * @return Flynsarmy\OrchestraCms\Providers\FileContentStorage
     */
    public function storage()
    {
        if ( !$this->_storage_provider )
            $this->_storage_provider = new FileContentStorage($this, Theme::getTheme());

        return $this->_storage_provider;
    }

    public function set_unique_content_dir()
    {
        $this->content_dir = $this->storage()->unique_content_dir();
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
