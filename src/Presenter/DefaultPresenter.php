<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\Component;
use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentContext;
use Flammel\Zweig\Component\ComponentName;
use Flammel\Zweig\Component\NameComponentTemplatePath;

final class DefaultPresenter implements Presenter
{
    /**
     * @param ComponentName $name
     * @param ComponentArguments $arguments
     * @return Component
     */
    public function present(ComponentName $name, ComponentArguments $arguments): Component
    {
        return new Component(
            new NameComponentTemplatePath($name),
            new ComponentContext($arguments->toArray())
        );
    }
}
