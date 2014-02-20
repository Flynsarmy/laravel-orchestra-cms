<?php namespace Flynsarmy\OrchestraCms;

use Illuminate\Support\ServiceProvider;
use Flynsarmy\OrchestraCms\Models\Template;
use Flynsarmy\OrchestraCms\Models\Page;
use Flynsarmy\OrchestraCms\Models\Partial;
use Flynsarmy\OrchestraCms\Repositories\DbTemplate;
use Flynsarmy\OrchestraCms\Repositories\DbPage;
use Flynsarmy\OrchestraCms\Repositories\DbPartial;
use Orchestra\Theme;

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
        /*
         * Controller repositories
         */
        $this->app->bind(
            'Flynsarmy\OrchestraCms\Repositories\Interfaces\Template', function($app) {
                return new DbTemplate(new Template);
            }
        );
        $this->app->bind(
            'Flynsarmy\OrchestraCms\Repositories\Interfaces\Page', function($app) {
                return new DbPage(new Page);
            }
        );
        $this->app->bind(
            'Flynsarmy\OrchestraCms\Repositories\Interfaces\Partial', function($app) {
                return new DbPartial(new Partial);
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
