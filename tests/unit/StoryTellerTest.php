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
        $actual = Story::permalink($model);
        $expected = handles("flynsarmy/orchestra-cms::/foo");
        Assert::equals($expected, $actual);

        // Nested slug test
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar');
        $actual = Story::permalink($model);
        $expected = handles("flynsarmy/orchestra-cms::/foo/bar");
        Assert::equals($expected, $actual);

        // Strip suffix slash test
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar/');
        $actual = Story::permalink($model);
        $expected = handles("flynsarmy/orchestra-cms::/foo/bar");
        Assert::equals($expected, $actual);

        // ID test
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{id}");
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar/');
        $actual = Story::permalink($model);
        $expected = handles("flynsarmy/orchestra-cms::/1");
        Assert::equals($expected, $actual);

        // ID and slug test
        $this->app['config']->set("flynsarmy/orchestra-cms::permalink", "{id}/{slug}");
        $model = (object)array('id'=>1, 'slug'=>'/foo/bar');
        $actual = Story::permalink($model);
        $expected = handles("flynsarmy/orchestra-cms::/1/foo/bar");
        Assert::equals($expected, $actual);
    }
}