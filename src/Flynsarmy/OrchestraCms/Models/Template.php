<?php namespace Flynsarmy\OrchestraCms\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Template extends CmsModel
{
    protected $guarded = ['created_at', 'content_path'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orchestra_cms_templates';

    /**
     * Belongs to relationship with Template.
     */
    public function pages()
    {
        return $this->hasMany('Flynsarmy\OrchestraCms\Models\Page');
    }
}
