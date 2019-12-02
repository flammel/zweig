<?php

namespace Flammel\Zweig\Presenter;

use Flammel\Zweig\Component\ComponentContext;
use Flammel\Zweig\TemplatePath\TemplatePath;

final class Presentable
{
    /**
     * @var TemplatePath
     */
    private $path;

    /**
     * @var ComponentContext
     */
    private $context;

    public function __construct(TemplatePath $path, ComponentContext $context)
    {
        $this->path = $path;
        $this->context = $context;
    }

    /**
     * @return TemplatePath
     */
    public function getPath(): TemplatePath
    {
        return $this->path;
    }

    /**
     * @return ComponentContext
     */
    public function getContext(): ComponentContext
    {
        return $this->context;
    }
}
