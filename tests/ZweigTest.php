<?php

namespace Flammel\Zweig\Tests;

use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentName;
use Flammel\Zweig\Exception\ZweigException;
use Flammel\Zweig\Presenter\DefaultPresenter;
use Flammel\Zweig\Renderer\ComponentRenderer;
use Flammel\Zweig\Twig\ZweigExtension;
use Flammel\Zweig\Twig\ZweigRuntimeExtension;
use Flammel\Zweig\Twig\ZweigRuntimeLoader;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ZweigTest extends TestCase
{
    /**
     * @var ComponentRenderer
     */
    private $renderer;

    public function setUp(): void
    {
        $presenter = new DefaultPresenter();
        $twig = new Environment(new FilesystemLoader([__DIR__]));
        $twig->addExtension(new ZweigExtension());
        $renderer = new ComponentRenderer($twig, $presenter);
        $twig->addRuntimeLoader(new ZweigRuntimeLoader(new ZweigRuntimeExtension($renderer)));
        $this->renderer = $renderer;
    }

    /**
     * @throws \Flammel\Zweig\Exception\ZweigException
     */
    public function testRendering(): void
    {
        $arguments = new ComponentArguments(['headline' => 'Test Headline']);
        $name = new ComponentName('Page');
        $this->assertEquals(
            file_get_contents(__DIR__ . '/Page.html'),
            $this->renderer->render($name, $arguments)
        );
    }

    /**
     * @throws \Flammel\Zweig\Exception\ZweigException
     */
    public function testUnclosedComponent(): void
    {
        $arguments = new ComponentArguments([]);
        $name = new ComponentName('UnclosedComponent');
        $this->expectException(ZweigException::class);
        $this->renderer->render($name, $arguments);
    }
}
