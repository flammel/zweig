<?php

namespace Flammel\Zweig\Tests\Presenter;

use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentContext;
use Flammel\Zweig\Component\ComponentName;
use Flammel\Zweig\Component\NameComponentTemplatePath;
use Flammel\Zweig\Presenter\DefaultPresenter;
use PHPUnit\Framework\TestCase;

class DefaultPresenterTest extends TestCase
{
    public function testUsesNameComponentTemplatePath(): void
    {
        $presenter = new DefaultPresenter();
        $component = $presenter->present(new ComponentName('ComponentName'), new ComponentArguments([]));
        $this->assertInstanceOf(NameComponentTemplatePath::class, $component->getPath());
    }

    public function testDoesNotModifyName(): void
    {
        $presenter = new DefaultPresenter();
        $name = new ComponentName('ComponentName');
        $component = $presenter->present($name, new ComponentArguments([]));
        $this->assertEquals((new NameComponentTemplatePath($name))->getPath(), $component->getPath()->getPath());
    }

    public function testPassesAllArgumentsToContext(): void
    {
        $presenter = new DefaultPresenter();
        $args = ['x' => 1, 2 => ['y' => 'z']];
        $component = $presenter->present(new ComponentName('ComponentName'), new ComponentArguments($args));
        $this->assertEquals(
            (new ComponentContext($args))->toContextArray(),
            $component->getContext()->toContextArray()
        );
    }
}
