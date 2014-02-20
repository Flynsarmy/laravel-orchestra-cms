<?php namespace Flynsarmy\OrchestraCms\Controllers\Backend;

use Illuminate\Support\Facades\Input;
use Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Flynsarmy\OrchestraCms\Models\Template;
use Flynsarmy\OrchestraCms\Validation\Page as PageValidator;
use Flynsarmy\OrchestraCms\Repositories\Interfaces\Page as PageRepositoryInterface;

class PageController extends ContentController
{
    protected $type = 'page';
    protected $resource = 'orchestra-cms.pages';

    /**
     * Page CRUD Controller.
     *
     * @param \Flynsarmy\OrchestraCms\Validation\Page  $validator
     */
    public function __construct(PageRepositoryInterface $content, PageValidator $validator)
    {
        parent::__construct();

        $this->validator = $validator;
        $this->content = $content;
    }

    /**
     * List all the pages.
     *
     * @return Response
     */
    public function index()
    {
        Site::set('title', 'List of Pages');

        $contents = $this->content->getAll(Input::all());

        return View::make('flynsarmy/orchestra-cms::backend.page.index', compact('contents'));
    }

    /**
     * Write a page.
     *
     * @return Response
     */
    public function create()
    {
        Site::set('title', 'Write a Page');

        $content         = $this->content->create();
        $templates       = Template::get()->lists('title', 'id');

        return View::make('flynsarmy/orchestra-cms::backend.page.editor', array(
            'content'   => $content,
            'templates' => $templates,
            'url'       => resources('orchestra-cms.pages'),
            'method'    => 'POST',
        ));
    }

    /**
     * Store a page.
     *
     * @return Response
     */
    public function store()
    {
        $input         = Input::all();
        $validation    = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return Redirect::to(resources("{$this->resource}/create"))
                    ->withInput()->withErrors($validation);
        }

        $content = $this->content->store( $input );

        Messages::add('success', 'Page has been created.');
        return Redirect::to(resources("orchestra-cms.pages/{$content->id}/edit"));
    }

    /**
     * Edit a page.
     *
     * @return Response
     */
    public function edit($id = null)
    {
        Site::set('title', 'Write a Page');

        $content = $this->content->find( $id );
        $templates = Template::lists('title', 'id');

        return View::make('flynsarmy/orchestra-cms::backend.page.editor', array(
            'content'   => $content,
            'templates' => $templates,
            'url'       => resources("orchestra-cms.pages/{$content->id}"),
            'method'    => 'PUT',
        ));
    }

    /**
     * Update a page.
     *
     * @return Response
     */
    public function update($id = null)
    {
        $input         = Input::all();
        $validation    = $this->validator->on('update')->bind(array('id_val' => $id))->with($input);

        if ($validation->fails()) {
            return Redirect::to(resources("{$this->resource}/{$id}/edit"))
                    ->withInput()->withErrors($validation);
        }

        $content = $this->content->update( $id, $input );

        Messages::add('success', 'Page has been updated.');
        return Redirect::to(resources("orchestra-cms.pages/{$content->id}/edit"));
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->content->destroy($id);

        Messages::add('success', 'Page has been deleted.');
        return Redirect::to(resources('orchestra-cms.pages'));
    }
}
