<?php namespace Flynsarmy\OrchestraCms\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Partial extends CmsModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orchestra_cms_partials';

    /**
     * The folder in our public theme directory all views will be saved into
     *
     * @var string
     */
    protected $view_base_path = 'partials';
}
