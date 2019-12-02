<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentName;

interface Presenter
{
    /**
     * @param ComponentName $name
     * @param ComponentArguments $arguments
     * @return Presentable
     */
    public function present(ComponentName $name, ComponentArguments $arguments): Presentable;
}
