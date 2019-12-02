<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\ComponentName;

final class DefaultPresenterFactory implements PresenterFactory
{
    /**
     * @var Presenter
     */
    private $defaultPresenter;

    /**
     * @param Presenter $defaultPresenter
     */
    public function __construct(Presenter $defaultPresenter)
    {
        $this->defaultPresenter = $defaultPresenter;
    }

    /**
     * @param ComponentName $componentName
     * @return Presenter
     */
    public function getPresenter(ComponentName $componentName): Presenter
    {
        return $this->defaultPresenter;
    }
}
