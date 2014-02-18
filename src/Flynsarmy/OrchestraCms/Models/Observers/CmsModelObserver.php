<?php namespace Flynsarmy\OrchestraCms\Models\Observers;

use App, File;
use Orchestra\Theme;

class CmsModelObserver
{
	public function saveContent( $model )
	{
		if ( !$model->theme )
			$model->theme = Theme::getTheme();

		$base_path = $model->getAbsContentBasePath( $model->theme );
		$content_path = $model->getOrSetRelContentPath();
		$abspath = "{$base_path}/{$content_path}";
		$absfilepath = $abspath . '/content.blade.php';

		// Create templates directory
		if ( !File::isDirectory($abspath) )
			File::makeDirectory($abspath, 0777, true);

		// Write template contents
		File::put($absfilepath, $model->content);
	}

	public function deleteContent( $model )
	{
		$base_path = $model->getAbsContentBasePath( $model->theme );
		$content_path = $model->getOrSetRelContentPath();
		$abspath = "{$base_path}/{$content_path}";

		File::deleteDirectory( $abspath );
	}
}