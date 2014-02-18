<?php namespace Flynsarmy\OrchestraCms\Validation;

use Orchestra\Support\Validator;

class Page extends Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = array(
        'title'         => array('required'),
        'slug'          => array('required'),
        'template_id'   => array('required', 'exists:orchestra_cms_templates,id'),
        'content'       => array('required'),
    );

    /**
     * On create scenario
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['slug'] = array('required', 'unique:orchestra_cms_pages,slug');
    }

    /**
     * On update scenario.
     *
     * @return void
     */
    protected function onUpdate()
    {
        $this->rules['slug'] = array('required', 'unique:orchestra_cms_pages,slug,{id_val}');
    }
}
