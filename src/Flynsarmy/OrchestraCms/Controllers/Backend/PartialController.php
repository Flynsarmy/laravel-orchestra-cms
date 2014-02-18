<?php namespace Flynsarmy\OrchestraCms\Controllers\Backend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Flynsarmy\OrchestraCms\Validation\Partial as PartialValidator;
use Flynsarmy\OrchestraCms\Interfaces\PartialRepositoryInterface;

class PartialController extends ContentController
{
    protected $type = 'partial';
    protected $resource = 'orchestra-cms.partials';

    /**
     * Partial CRUD Controller.
     *
     * @param \Flynsarmy\OrchestraCms\Validation\Partial  $validator
     */
    public function __construct(PartialRepositoryInterface $content, PartialValidator $validator)
    {
        parent::__construct();

        $this->validator = $validator;
        $this->content = $content;
    }

    /**
     * List all the partials.
     *
     * @return Response
     */
    public function index()
    {
        Site::set('title', 'List of Partials');

        $contents = $this->content->getAll(Input::all());

        return View::make('flynsarmy/orchestra-cms::backend.partial.index', compact('contents', 'type'));
    }

    /**
     * Write a page.
     *
     * @return Response
     */
    public function create()
    {
        Site::set('title', 'Write a Partial');

        $content         = $this->content->create();

        return View::make('flynsarmy/orchestra-cms::backend.partial.editor', array(
            'content'   => $content,
            'url'       => resources('orchestra-cms.partials'),
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

        Messages::add('success', 'Partial has been created.');
        return Redirect::to(resources("orchestra-cms.partials/{$content->id}/edit"));
    }

    /**
     * Edit a page.
     *
     * @return Response
     */
    public function edit($id = null)
    {
        Site::set('title', 'Write a Partial');

        $content = $this->content->find( $id );

        return View::make('flynsarmy/orchestra-cms::backend.partial.editor', array(
            'content'   => $content,
            'url'       => resources("orchestra-cms.partials/{$content->id}"),
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

        $content = $this->content->update($id, $input);

        Messages::add('success', 'Partial has been updated.');
        return Redirect::to(resources("orchestra-cms.partials/{$content->id}/edit"));
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->content->destroy( $id );

        Messages::add('success', 'Partial has been deleted.');
        return Redirect::to(resources('orchestra-cms.partials'));
    }
}
