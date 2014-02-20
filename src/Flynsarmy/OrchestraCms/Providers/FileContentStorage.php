<?php namespace Flynsarmy\OrchestraCms\Providers;

use App;
use File;
use Flynsarmy\OrchestraCms\Providers\Interfaces\ContentStorage;

class FileContentStorage implements ContentStorage {

    protected $theme;
    protected $rel_base_path;

    public function __construct(Theme $theme, $rel_base_page = '')
    {
        $this->theme = $theme;
        $this->rel_base_page = $rel_base_page;
    }

    public function base_path()
    {
        return App::make('path.public') . '/themes/' . $this->theme . '/packages/flynsarmy/orchestra-cms';
    }

    public function rel_path( $slug )
    {
        return $this->rel_base_path . '/' . $slug;
    }

    public function abs_path( $slug )
    {
        return $this->base_path() . '/' . $this->rel_path( $slug );
    }

    public function unique_rel_path( $slug )
    {
        $i = 0;
        $new_slug = $slug;

        while ( File::isDirectory($this->abs_path($new_slug)) )
            $new_slug = $slug . '-' . ++$i;


        return $this->rel_path($new_slug);
    }
}