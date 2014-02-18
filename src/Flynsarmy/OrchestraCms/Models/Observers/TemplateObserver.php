<?php namespace Flynsarmy\OrchestraCms\Models\Observers;

use Auth;
use Orchestra\Theme;
use Flynsarmy\OrchestraCms\Exceptions\TemplateNotDeletedException;

class TemplateObserver extends CmsModelObserver
{
	public function creating($model)
	{
		if ( !$model->user_id ) $model->user_id = Auth::user()->id;
		if ( !$model->theme ) $model->theme = Theme::getTheme();
	}

	public function saving($model)
	{
		$this->saveContent($model);
	}

	public function deleting($model)
	{
		if ( $model->pages()->count() )
			throw new TemplateNotDeletedException("There are still pages using this template. Please update them to use another template first.");

		$this->deleteContent($model);
	}
}