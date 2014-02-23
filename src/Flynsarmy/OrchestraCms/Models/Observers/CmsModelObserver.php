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

		$file_path = $model->storage()->abs_path('content.blade.php');
		$abs_path = dirname($file_path);

		if ( !File::isDirectory($abs_path) )
			File::makeDirectory($abs_path, 0777, true);

		File::put($file_path, $model->content);
	}

	public function deleteContent( $model )
	{
		$file_path = $model->storage()->abs_path('content.blade.php');
		$abs_path = dirname($file_path);

		File::deleteDirectory( $abs_path );
	}
}