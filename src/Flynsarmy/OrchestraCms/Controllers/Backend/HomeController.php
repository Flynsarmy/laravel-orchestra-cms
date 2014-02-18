<?php namespace Flynsarmy\OrchestraCms\Controllers\Backend;

use Illuminate\Support\Facades\Redirect;

class HomeController extends EditorController
{
    /**
     * Define filters for current controller.
     *
     * @return void
     */
    protected function setupFilters()
    {
        //
    }

    /**
     * Show Dashboard.
     *
     * @return Response
     */
    public function getIndex()
    {
        return Redirect::to(resources("orchestra-cms.pages"));
    }
}
