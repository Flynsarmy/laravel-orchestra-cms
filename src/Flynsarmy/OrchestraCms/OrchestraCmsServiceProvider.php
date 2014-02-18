<?php namespace Flynsarmy\OrchestraCms;

use Illuminate\Support\ServiceProvider;
use Flynsarmy\OrchestraCms\Models\Template;
use Flynsarmy\OrchestraCms\Models\Page;
use Flynsarmy\OrchestraCms\Models\Partial;
use Flynsarmy\OrchestraCms\Repositories\DbTemplateRepository;
use Flynsarmy\OrchestraCms\Repositories\DbPageRepository;
use Flynsarmy\OrchestraCms\Repositories\DbPartialRepository;

class OrchestraCmsServiceProvider extends ServiceProvider
{
    /**
     * Register service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerStoryTeller();
        $this->registerBindings();
    }

    /**
     * Register service provider.
     *
     * @return void
     */
    protected function registerStoryTeller()
    {
        $this->app['orchestra.story'] = $this->app->share(function ($app) {
            return new Storyteller($app);
        });
    }

    protected function registerBindings()
    {
        $this->app->bind(
            'Flynsarmy\OrchestraCms\Interfaces\TemplateRepositoryInterface', function($app) {
                return new DbTemplateRepository(new Template);
            }
        );
        $this->app->bind(
            'Flynsarmy\OrchestraCms\Interfaces\PageRepositoryInterface', function($app) {
                return new DbPageRepository(new Page);
            }
        );
        $this->app->bind(
            'Flynsarmy\OrchestraCms\Interfaces\PartialRepositoryInterface', function($app) {
                return new DbPartialRepository(new Partial);
            }
        );
    }

    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../');

        $this->package('flynsarmy/orchestra-cms', 'flynsarmy/orchestra-cms', $path);

        include "{$path}/start/global.php";
        include "{$path}/start/events.php";
        include "{$path}/filters.php";
        include "{$path}/routes.php";
    }
}
