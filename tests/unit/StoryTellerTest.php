<?php namespace Flynsarmy\OrchestraCms\Tests\Unit;

use TestCase;
use Way\Tests\Assert;
use Flynsarmy\OrchestraCms\Facades\Story;

class StoryTellerTest extends TestCase
{
    public function testPermalink()
    {
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{slug}");

        // Slug test
        $model = (object)array('id'=>1, 'slug'=>'/foo');
        Assert::equals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/foo"));

        // Nested slug test
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar');
        Assert::equals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/foo/bar"));

        // Strip suffix slash test
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar/');
        Assert::equals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/foo/bar"));

        // ID test
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{id}");
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar/');
        Assert::equals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/1"));

        // ID and slug test
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{id}/{slug}");
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar');
        Assert::equals(Story::permalink($model), handles("flynsarmy/orchestra-cms::/1/foo/bar"));
    }
}