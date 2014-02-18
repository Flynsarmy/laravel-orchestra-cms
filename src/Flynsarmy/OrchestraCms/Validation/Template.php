<?php namespace Flynsarmy\OrchestraCms\Validation;

use Orchestra\Support\Validator;

class Template extends Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = array(
        'title'   => array('required', 'regex:/^[\pL\pN]+[\pL\pN_-\s]*$/u'),
        'content' => array('required'),
    );

    /**
     * On create scenario
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['title'] = array('required', 'regex:/^[\pL\pN]+[\pL\pN_-\s]*$/u', 'unique:orchestra_cms_templates,title');
    }

    /**
     * On update scenario.
     *
     * @return void
     */
    protected function onUpdate()
    {
        $this->rules['title'] = array('required', 'regex:/^[\pL\pN]+[\pL\pN_-\s]*$/u', 'unique:orchestra_cms_templates,title,{id_val}');
    }
}
