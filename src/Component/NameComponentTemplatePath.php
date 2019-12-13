<?php

namespace Flammel\Zweig\Component;

class NameComponentTemplatePath implements ComponentTemplatePath
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param ComponentName $name
     */
    public function __construct(ComponentName $name)
    {
        $this->path = $name->getName() . '.twig';
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
