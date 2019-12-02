<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentContext;
use Flammel\Zweig\Component\ComponentName;
use Flammel\Zweig\TemplatePath\NameTemplatePath;

final class DefaultPresenter implements Presenter
{
    /**
     * @param ComponentName $name
     * @param ComponentArguments $arguments
     * @return Presentable
     */
    public function present(ComponentName $name, ComponentArguments $arguments): Presentable
    {
        return new Presentable(
            new NameTemplatePath($name),
            new ComponentContext($arguments->getArguments())
        );
    }
}
