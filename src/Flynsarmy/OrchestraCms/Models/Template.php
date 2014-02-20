<?php namespace Flynsarmy\OrchestraCms\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Template extends CmsModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orchestra_cms_templates';

    /**
     * The folder in our public theme directory all views will be saved into
     *
     * @var string
     */
    protected $view_base_path = 'templates';

    /**
     * Belongs to relationship with Template.
     */
    public function pages()
    {
        return $this->hasMany('Flynsarmy\OrchestraCms\Models\Page');
    }
}
