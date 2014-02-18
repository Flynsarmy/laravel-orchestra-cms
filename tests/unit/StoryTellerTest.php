<?php namespace Flynsarmy\OrchestraCms\Tests\Unit;

use TestCase;
use Flynsarmy\OrchestraCms\Facades\Story;

class StoryTellerTest extends TestCase
{
    public function testSlugify()
    {
        // Spaces to dash
        $title = 'this is a space test';
        $this->assertEquals(Story::slugify($title), 'this-is-a-space-test');

        // Upper to lower case
        $title = 'This Is A CapitaliZation Test';
        $this->assertEquals(Story::slugify($title), 'this-is-a-capitalization-test');

        // Special character removal
        $title = 'This: is "a string" with special - characters!';
        $this->assertEquals(Story::slugify($title), 'this-is-a-string-with-special-characters');

        // No text to n-a
        $title = '';
        $this->assertEquals(Story::slugify($title), 'n-a');
    }

    public function testPermalink()
    {
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{slug}");

        // Slug test
        $model = (object)array('id'=>1, 'slug'=>'/foo');
        $this->assertEquals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/foo"));

        // Nested slug test
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar');
        $this->assertEquals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/foo/bar"));

        // Strip suffix slash test
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar/');
        $this->assertEquals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/foo/bar"));

        // ID test
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{id}");
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar/');
        $this->assertEquals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/1"));

        // ID and slug test
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{id}/{slug}");
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar');
        $this->assertEquals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/1/foo/bar"));
    }
}