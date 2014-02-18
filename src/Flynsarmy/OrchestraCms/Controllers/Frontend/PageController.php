<?php namespace Flynsarmy\OrchestraCms\Controllers\Frontend;

use Controller;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Site;
use Flynsarmy\OrchestraCms\Models\Page;
use Orchestra\Support\Facades\Facile;
use Orchestra\Theme;

class PageController extends Controller
{
    /**
     * Show the content.
     *
     * @return Response
     */
    public function show()
    {
        $params = App::make('router')->getCurrentRoute()->getParameters();
        $slug   = '/'.array_get($params, 'slug');

        $page = $this->getRequestedContent($slug);
        $id   = $page->id;
        $slug = $page->slug;

        Site::set('title', $page->title);

        return $this->getResponse($page, $id, $slug);
    }

    /**
     * Return the response, this method allow each content type to be group
     * via different set of view.
     *
     * @param  \Flynsarmy\OrchestraCms\Model\Page   $page
     * @param  integer                          $id
     * @param  string                           $slug
     * @return Response
     */
    protected function getResponse($page, $id, $slug)
    {
        $template = $page->template;

        $data = array(
            'id'   => $id,
            'page' => $page,
            'slug' => $slug,
        );

        // Load OrchestraCms specific blade extensions like @partial() and @page()
        require_once __DIR__.'/../../../../blade-helpers.php';

        $view = $template->getViewPath() . '.content';

        return Facile::view($view)->with($data)->render();
    }

    /**
     * Get the requested page/content from Model.
     *
     * @param  string   $slug
     * @return \Flynsarmy\OrchestraCms\Model\Page
     */
    protected function getRequestedContent($slug)
    {
        if ( $slug && ($page = Page::enabled()->theme()->where('slug', $slug)->first()) )
            return $page;

        return App::abort(404);
    }
}
