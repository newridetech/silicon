<?php

namespace Newride\Silicon\bundles\content\tests\Models;

use DB;
use Newride\Silicon\bundles\content\Exceptions\ContentNotFound;
use Newride\Silicon\bundles\content\Exceptions\LocaleNotFound;
use Newride\Silicon\bundles\content\Models\StaticContent;
use Newride\Silicon\bundles\content\Models\StaticPage;
use Newride\Silicon\tests\TestCase;

class StaticPageTest extends TestCase
{
    public function cleanUp(): void
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

    public function setUp(): void
    {
        parent::setUp();

        $this->cleanUp();

        $staticPage = new StaticPage();
        $staticPage->route = 'test';
        $staticPage->saveOrFail();

        $this->staticPageId = $staticPage->id;
        $this->assertNotNull($this->staticPageId);

        $content = new StaticContent([
            'data' => [
                'foo' => 'bar',
            ],
            'locale' => 'pl',
        ]);

        $staticPage->contents()->save($content);
    }

    public function tearDown(): void
    {
        $this->cleanUp();

        parent::tearDown();
    }

    public function testThatNonContentIsSetAndRetrieved(): void
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $expected = 'wooz';
        $result = $staticPage->content('pl')->set('test.set', $expected)->save();

        $this->assertTrue($result);

        $fresh = $staticPage->fresh();

        $this->assertNotSame($staticPage, $fresh);

        $this->assertSame($expected, $fresh->content('pl')->get('test.set'));
    }

    public function testThatDataIsSerialized(): void
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->assertSame('bar', $staticPage->content('pl')->get('foo'));
    }

    public function testThatNonExistentContentAcceptsFallback(): void
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->assertSame('yyy', $staticPage->content('pl')->get('bar', 'yyy'));
    }

    public function testThatNonExistentContentThrowsError(): void
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->expectException(ContentNotFound::class);
        $staticPage->content('pl')->get('bar');
    }

    public function testThatNonExistentLocaleThrowsError(): void
    {
        $staticPage = StaticPage::findOrFail($this->staticPageId);

        $this->expectException(LocaleNotFound::class);
        $staticPage->content('xxx');
    }
}
