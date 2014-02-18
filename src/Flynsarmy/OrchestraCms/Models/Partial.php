<?php namespace Flynsarmy\OrchestraCms\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Partial extends CmsModel
{
    protected $guarded = ['created_at', 'content_path'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orchestra_cms_partials';
}
