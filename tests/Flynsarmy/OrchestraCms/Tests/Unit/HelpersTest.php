<?php namespace Flynsarmy\OrchestraCms\Tests\Unit;

use Flynsarmy\OrchestraCms\Tests\TestCase;
use Way\Tests\Assert;

class HelpersTest extends TestCase
{
    public function testSortContentsByLink()
    {
        // Initial URL test
        $actual = sort_contents_by_link('pages', 'title', 'asc');
        $expected = resources("orchestra-cms.pages?sortBy=title&order=asc");
        Assert::equals($expected, $actual);

        // Test content_type param
        $actual = sort_contents_by_link('templates', 'title', 'asc');
        $expected = resources("orchestra-cms.templates?sortBy=title&order=asc");
        Assert::equals($expected, $actual);

        // Test sortBy param
        $actual = sort_contents_by_link('pages', 'slug', 'asc');
        $expected = resources("orchestra-cms.pages?sortBy=slug&order=asc");
        Assert::equals($expected, $actual);

        // Test order param
        $actual = sort_contents_by_link('pages', 'title', 'desc');
        $expected = resources("orchestra-cms.pages?sortBy=title&order=desc");
        Assert::equals($expected, $actual);

        // Test overwritten params
        $actual = sort_contents_by_link('pages', 'title', 'asc', array('sortBy' => 'foo'));
        $expected = resources("orchestra-cms.pages?sortBy=title&order=asc");
        Assert::equals($expected, $actual);

        // Test extra params
        $actual = sort_contents_by_link('pages', 'title', 'asc', array('foo' => 'bar'));
        $expected = resources("orchestra-cms.pages?foo=bar&sortBy=title&order=asc");
        Assert::equals($expected, $actual);
    }
}