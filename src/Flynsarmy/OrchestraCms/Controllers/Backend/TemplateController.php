<?php namespace Flynsarmy\OrchestraCms\Controllers\Backend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Flynsarmy\OrchestraCms\Exceptions\TemplateNotDeletedException;
use Flynsarmy\OrchestraCms\Validation\Template as TemplateValidator;
use Flynsarmy\OrchestraCms\Interfaces\TemplateRepositoryInterface;

class TemplateController extends ContentController
{
    protected $type = 'template';
    protected $resource = 'orchestra-cms.templates';

    /**
     * Template CRUD Controller.
     *
     * @param \Flynsarmy\OrchestraCms\Validation\Template  $validator
     */
    public function __construct(TemplateRepositoryInterface $content, TemplateValidator $validator)
    {
        parent::__construct();

        $this->validator = $validator;
        $this->content = $content;
    }

    /**
     * List all the templates.
     *
     * @return Response
     */
    public function index()
    {
        $type = 'template';
        $contents = $this->content->getAll(Input::all());

        Site::set('title', 'List of Templates');

        return View::make('flynsarmy/orchestra-cms::backend.template.index', compact('contents', 'type'));
    }

    /**
     * Write a page.
     *
     * @return Response
     */
    public function create()
    {
        Site::set('title', 'Write a Template');

        $content = $this->content->create();

        return View::make('flynsarmy/orchestra-cms::backend.template.editor', array(
            'content'   => $content,
            'url'       => resources('orchestra-cms.templates'),
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

        Messages::add('success', 'Template has been created.');
        return Redirect::to(resources("orchestra-cms.templates/{$content->id}/edit"));
    }

    /**
     * Edit a page.
     *
     * @return Response
     */
    public function edit($id = null)
    {
        Site::set('title', 'Write a Template');

        $content = $this->content->find( $id );

        return View::make('flynsarmy/orchestra-cms::backend.template.editor', array(
            'content'   => $content,
            'url'       => resources("orchestra-cms.templates/{$content->id}"),
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

        Messages::add('success', 'Template has been updated.');
        return Redirect::to(resources("orchestra-cms.templates/{$content->id}/edit"));
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->content->destroy( $id );
        }
        catch (TemplateNotDeletedException $e) {
            $content = $this->content->find( $id );

            return Redirect::to(resources("{$this->resource}/{$content->id}/edit"))
                ->withErrors(['pages' => $e->getMessage()]);
        }


        Messages::add('success', 'Template has been deleted.');
        return Redirect::to(resources('orchestra-cms.templates'));
    }
}
