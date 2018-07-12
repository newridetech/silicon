<?php

namespace Newride\Silicon\bundles\extensions;

use Parsedown;
use PHPUnit\Framework\TestCase;

class ExtensionReadmeTest extends TestCase
{
    public function testExtensionTitleIsObtained()
    {
        $extensionReadme = new ExtensionReadme(__DIR__.'/fixtures/EXTENSION_README.md', new Parsedown());

        $this->assertSame('test title', $extensionReadme->getTitle());
    }

    public function testReadmeHtmlIsGenerated()
    {
        $extensionReadme = new ExtensionReadme(__DIR__.'/fixtures/EXTENSION_README.md', new Parsedown());

        $this->assertSame('<h1>test title</h1>', $extensionReadme->toHtml());
    }
}
