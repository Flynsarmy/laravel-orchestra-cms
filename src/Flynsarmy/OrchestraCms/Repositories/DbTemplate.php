<?php namespace Flynsarmy\OrchestraCms\Repositories;

use \Config;
use \View;
use Flynsarmy\OrchestraCms\Repositories\DbContent;
use Flynsarmy\OrchestraCms\Repositories\Interfaces\Template as TemplateRepositoryInterface;

class DbTemplate extends DbContent implements TemplateRepositoryInterface {

	public function create()
	{
		$content_view   = Config::get('flynsarmy/orchestra-cms::default_template_content_view', '');

        if ( $content_view && View::exists($content_view) )
            $this->model->content   = file_get_contents(View::make($content_view)->getPath());

        return $this->model;
	}

}