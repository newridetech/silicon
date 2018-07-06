<?php

namespace Newride\Laroak\bundles\content\tests\Models;

use DB;
use Newride\Laroak\bundles\content\Exceptions\ContentNotFound;
use Newride\Laroak\bundles\content\Exceptions\LocaleNotFound;
use Newride\Laroak\bundles\content\Models\StaticContent;
use Newride\Laroak\bundles\content\Models\StaticPage;
use Newride\Laroak\tests\TestCase;

class StaticPageTest extends TestCase
{
    public function cleanUp()
    {
        $staticPage = DB::table('laroak_static_pages')
            ->where('route', 'test')
            ->first()
        ;

        if (empty($staticPage)) {
            return;
        }

        $content = DB::table('laroak_static_contents')
            ->where('owner_id', $staticPage->id)
            ->first()
        ;

        DB::table('laroak_static_pages')
            ->where('id', $staticPage->id)
            ->delete()
        ;

        if (empty($content)) {
            return;
        }

        DB::table('laroak_static_contents')
            ->where('id', $content->id)
            ->delete()
        ;
    }

    public function setUp()
    {
        parent::setUp();

        $this->cleanUp();

        $staticPage = new StaticPage();
        $staticPage->route = 'test';
        $staticPage->saveOrFail();

        $this->staticPageId = $staticPage->id;
        $this->assertNotNull($this->staticPageId);

        $content = new StaticContent();
        $content->setOwner($staticPage);
        $content->data = [
            'foo' => 'bar',
        ];
        $content->locale = 'pl';
        $content->saveOrFail();

        $this->contentId = $content->id;
        $this->assertNotNull($this->contentId);
    }

    public function tearDown()
    {
        $this->cleanUp();

        parent::tearDown();
    }

    public function testThatDataIsSerialized()
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->assertSame('bar', $staticPage->content('pl')->get('foo'));
    }

    public function testThatNonExistentContentAcceptsFallback()
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->assertSame('yyy', $staticPage->content('pl')->get('bar', 'yyy'));
    }

    public function testThatNonExistentContentThrowsError()
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->expectException(ContentNotFound::class);
        $staticPage->content('pl')->get('bar');
    }

    public function testThatNonExistentLocaleThrowsError()
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->expectException(LocaleNotFound::class);
        $staticPage->content('xxx');
    }
}
