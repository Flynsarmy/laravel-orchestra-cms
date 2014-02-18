<?php namespace Flynsarmy\OrchestraCms\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Flynsarmy\OrchestraCms\Facades\Story;

class Page extends CmsModel
{
    protected $guarded = ['created_at', 'content_path'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orchestra_cms_pages';

    protected $content_string = null;

    /**
     * Belongs to relationship with Template.
     */
    public function template()
    {
        return $this->belongsTo('Flynsarmy\OrchestraCms\Models\Template');
    }

    public function scopeEnabled($query)
    {
        $query->where('is_enabled', '=', true);
    }

    /**
     * Accessor for link.
     *
     * @param  mixed   $value
     * @return string
     */
    public function getLinkAttribute($value)
    {
        return Story::permalink($this);
    }
}
