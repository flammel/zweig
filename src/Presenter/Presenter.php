<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\Component;
use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentName;

interface Presenter
{
    /**
     * @param ComponentName $name
     * @param ComponentArguments $arguments
     * @return Component
     */
    public function present(ComponentName $name, ComponentArguments $arguments): Component;
}
