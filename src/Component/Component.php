<?php

namespace Flammel\Zweig\Component;

final class Component
{
    /**
     * @var ComponentTemplatePath
     */
    private $path;

    /**
     * @var ComponentContext
     */
    private $context;

    /**
     * @param ComponentTemplatePath $path
     * @param ComponentContext $context
     */
    public function __construct(ComponentTemplatePath $path, ComponentContext $context)
    {
        $this->path = $path;
        $this->context = $context;
    }

    /**
     * @return ComponentTemplatePath
     */
    public function getPath(): ComponentTemplatePath
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
