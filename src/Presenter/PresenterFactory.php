<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\ComponentName;

interface PresenterFactory
{
    /**
     * @param ComponentName $componentName
     * @return Presenter
     */
    public function getPresenter(ComponentName $componentName): Presenter;
}
