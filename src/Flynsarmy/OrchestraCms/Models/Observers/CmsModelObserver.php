<?php namespace Flynsarmy\OrchestraCms\Models\Observers;

use App, File, Str;
use Orchestra\Theme;

class CmsModelObserver
{
	public function saveContent( $model )
	{
		if ( !$model->theme )
			$model->theme = Theme::getTheme();

		if ( !$model->exists )
			$model->set_unique_content_dir();

		$model->storage()->put('content.blade.php', $model->content);
	}

	public function deleteContent( $model )
	{
		$model->storage()->delete();
	}
}