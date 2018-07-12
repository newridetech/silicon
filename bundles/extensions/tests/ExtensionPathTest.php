<?php

namespace Newride\Silicon\bundles\extensions;

use PHPUnit\Framework\TestCase;

class ExtensionPathTest extends TestCase
{
    public function testExtensionClassIsGenerated()
    {
        $extensionPath = new ExtensionPath(__DIR__);

        $this->assertSame('base_namespace\extensions\Extension', $extensionPath->getExtensionClass('base_namespace'));
    }
}
