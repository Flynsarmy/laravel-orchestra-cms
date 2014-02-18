<?php namespace Flynsarmy\OrchestraCms\Controllers\Backend;

use Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Orchestra\Support\Facades\Site;

abstract class EditorController extends Controller
{
    /**
     * Define filter for the controller.
     */
    public function __construct()
    {
        $this->setupFormat();
        $this->setupFilters();
    }

    /**
     * Setup content format type.
     *
     * @return void
     */
    protected function setupFormat()
    {
        $format = 'ace';
        $this->beforeFilter("orchestra.story.editor:{$format}");
        $this->editorFormat = $format;
    }

    /**
     * Define filters for current controller.
     *
     * @return void
     */
    abstract protected function setupFilters();
}
