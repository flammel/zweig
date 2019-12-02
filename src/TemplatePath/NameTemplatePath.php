<?php

namespace Flammel\Zweig\TemplatePath;

use Flammel\Zweig\Component\ComponentName;

class NameTemplatePath implements TemplatePath
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
