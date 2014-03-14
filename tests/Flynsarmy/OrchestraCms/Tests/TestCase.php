<?php namespace Flynsarmy\OrchestraCms\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->getEnvironmentSetUp($this->app);
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @return array
     */
    protected function getPackageProviders()
    {
         return [
            'Orchestra\Asset\AssetServiceProvider',
            'Orchestra\Auth\AuthServiceProvider',
            'Orchestra\Debug\DebugServiceProvider',
            'Orchestra\View\DecoratorServiceProvider',
            'Orchestra\Extension\ExtensionServiceProvider',
            'Orchestra\Facile\FacileServiceProvider',
            'Orchestra\Html\HtmlServiceProvider',
            'Orchestra\Memory\MemoryServiceProvider',
            'Orchestra\Support\MessagesServiceProvider',
            'Orchestra\Notifier\NotifierServiceProvider',
            'Orchestra\Optimize\OptimizeServiceProvider',
            'Orchestra\Extension\PublisherServiceProvider',
            // 'Orchestra\Foundation\Reminders\ReminderServiceProvider',
            'Orchestra\Resources\ResourcesServiceProvider',
            'Orchestra\Foundation\SiteServiceProvider',
            'Orchestra\Translation\TranslationServiceProvider',
            'Orchestra\View\ViewServiceProvider',
            'Orchestra\Widget\WidgetServiceProvider',

            'Orchestra\Foundation\ConsoleSupportServiceProvider',
            'Orchestra\Foundation\FoundationServiceProvider',

            'Flynsarmy\OrchestraCms\OrchestraCmsServiceProvider',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Illuminate\Foundation\Application    $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        $app['path.base'] = __DIR__ . '/../src';

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }
}