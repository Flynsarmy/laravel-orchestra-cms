<?php namespace Flynsarmy\OrchestraCms\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Site;
use Flynsarmy\OrchestraCms\Models\Content;

abstract class ContentController extends EditorController
{
    /**
     * Repository instance.
     *
     * @var object
     */
    protected $content;

   /**
     * Current Resource.
     *
     * @var string
     */
    protected $resource;

    /**
     * Validation instance.
     *
     * @var object
     */
    protected $validator = null;



    /**
     * Define filters for current controller.
     *
     * @return void
     */
    public function setupFilters()
    {
        $this->beforeFilter(function () {
            if (Auth::guest()) {
                return Redirect::to(handles('orchestra::/'));
            }
        });

        $this->beforeFilter('orchestra.story:create-'.$this->type, array(
            'only' => array('create', 'store'),
        ));

        $this->beforeFilter('orchestra.story:update-'.$this->type, array(
            'only' => array('edit', 'update'),
        ));

        $this->beforeFilter('orchestra.story:delete-'.$this->type, array(
            'only' => array('delete', 'destroy'),
        ));
    }

    /**
     * List all the contents.
     *
     * @return Response
     */
    abstract public function index();

    /**
     * Write a content.
     *
     * @return Response
     */
    abstract public function create();

    /**
     * Edit a content.
     *
     * @return Response
     */
    abstract public function edit($id = null);

    /**
     * Store a content.
     *
     * @return Response
     */
    // abstract protected function storeCallback($content, $input);

    /**
     * Update a content.
     *
     * @return Response
     */
    // abstract protected function updateCallback($content, $input);

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function delete($id = null)
    {
        return $this->destroy($id);
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    // abstract protected function destroyCallback($content);
}
