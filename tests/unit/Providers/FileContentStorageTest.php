<?php namespace Flynsarmy\OrchestraCms\Tests\Unit\Providers;

use App;
use TestCase;
use Way\Tests\Assert;
use Mockery;
use Flynsarmy\OrchestraCms\Providers\FileContentStorage;

class FileContentStorageTest extends TestCase
{
    public function setUp()
    {
        $this->page_model = Mockery::namedMock('Page', 'Flynsarmy\OrchestraCms\Models\Page');
        $this->default_page_storage = new FileContentStorage($this->page_model, 'default');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testThemePath()
    {
        $base_path = App::make('path.public');

        $expected =  "$base_path/themes/default/packages/flynsarmy/orchestra-cms";
        $actual = $this->default_page_storage->theme_path();
        Assert::equals($expected, $actual);
    }

    public function testContentTypeDir()
    {
        // Test Page base path
        $expected = "pages";
        $actual = $this->default_page_storage->content_type_dir();
        Assert::equals($expected, $actual);

        // Test Template base path
        $template_model = Mockery::namedMock('Template', 'Flynsarmy\OrchestraCms\Models\Template');
        $storage = new FileContentStorage($template_model, 'default');
        $expected = "templates";
        $actual = $storage->content_type_dir();
        Assert::equals($expected, $actual);
    }

    public function testContentDir()
    {
        // Test slug of model with 'contact-us' content_path
        $this->page_model
            ->shouldReceive('getAttribute')
            ->once()
            ->with('content_dir')
            ->andReturn('contact-us')
            ->mock();
        $expected = "contact-us";
        $actual = $this->default_page_storage->content_dir();
        Assert::equals($expected, $actual);
    }

    public function testRelDir()
    {
        $this->page_model
            ->shouldReceive('getAttribute')
            ->once()
            ->with('content_dir')
            ->andReturn('contact-us')
            ->mock();
        $expected = "pages/contact-us";
        $actual = $this->default_page_storage->rel_dir();
        Assert::equals($expected, $actual);
    }

    public function testRelPath()
    {
        $this->page_model
            ->shouldReceive('getAttribute')
            ->once()
            ->with('content_dir')
            ->andReturn('contact-us')
            ->mock();
        $expected = "pages/contact-us/content";
        $actual = $this->default_page_storage->rel_path('content');
        Assert::equals($expected, $actual);
    }

    public function testAbsPath()
    {
        $this->page_model
            ->shouldReceive('getAttribute')
            ->once()
            ->with('content_dir')
            ->andReturn('contact-us')
            ->mock();
        $base_path = App::make('path.public');

        $expected =  "$base_path/themes/default/packages/flynsarmy/orchestra-cms/pages/contact-us/content";
        $actual = $this->default_page_storage->abs_path('content');
        Assert::equals($expected, $actual);
    }

    public function testViewPath()
    {
        $this->page_model
            ->shouldReceive('getAttribute')
            ->once()
            ->with('content_dir')
            ->andReturn('contact-us')
            ->mock();
        $expected = "flynsarmy/orchestra-cms::pages.contact-us.content";
        $actual = $this->default_page_storage->view_path('content');
        Assert::equals($expected, $actual);
    }
}