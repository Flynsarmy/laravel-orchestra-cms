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
			$model->set_content_path();

		$abs_path = $model->storage()->abs_path($model->content_path);
		$filepath = $abs_path . '/content.blade.php';

		if ( !File::isDirectory($abs_path) )
			File::makeDirectory($abs_path, 0777, true);

		File::put($filepath, $model->content);
	}

	public function deleteContent( $model )
	{
		$rel_path = $model->content_path;
		$abs_path = $model->storage()->abs_path( $rel_path );

		File::deleteDirectory( $abs_path );
	}
}