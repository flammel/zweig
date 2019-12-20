<?php

namespace Flammel\Zweig\Tests\Component;

use Flammel\Zweig\Component\ComponentName;
use Flammel\Zweig\Component\NameComponentTemplatePath;
use PHPUnit\Framework\TestCase;

class NameComponentTemplatePathTest extends TestCase
{
    public function testAppendsTwigExtensionToName(): void
    {
        $path = new NameComponentTemplatePath(new ComponentName('MyComponentName'));
        $this->assertEquals('MyComponentName.twig', $path->getPath());
    }
}
