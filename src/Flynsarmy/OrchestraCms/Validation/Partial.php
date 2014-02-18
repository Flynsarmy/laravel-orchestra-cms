<?php namespace Flynsarmy\OrchestraCms\Validation;

use Orchestra\Support\Validator;

class Partial extends Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = array(
        'title'   => array('required', 'alpha_dash'),
        'content' => array('required'),
    );

    /**
     * On create scenario
     *
     * @return void
     */
    protected function onCreate()
    {
        $this->rules['title'] = array('required', 'alpha_dash', 'unique:orchestra_cms_partials,title');
    }

    /**
     * On update scenario.
     *
     * @return void
     */
    protected function onUpdate()
    {
        $this->rules['title'] = array('required', 'alpha_dash', 'unique:orchestra_cms_partials,title,{id_val}');
    }
}
