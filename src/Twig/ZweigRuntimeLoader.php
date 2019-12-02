<?php

namespace Flammel\Zweig\Twig;

use Twig\RuntimeLoader\RuntimeLoaderInterface;

class ZweigRuntimeLoader implements RuntimeLoaderInterface
{
    /**
     * @var ZweigRuntimeExtension
     */
    private $runtimeExtension;

    /**
     * @param ZweigRuntimeExtension $runtimeExtension
     */
    public function __construct(ZweigRuntimeExtension $runtimeExtension)
    {
        $this->runtimeExtension = $runtimeExtension;
    }

    /**
     * Creates the runtime implementation of a Twig element (filter/function/test).
     *
     * @param string $class
     * @return object|null
     */
    public function load(string $class)
    {
        if ($class === ZweigRuntimeExtension::class) {
            return $this->runtimeExtension;
        }
        return null;
    }
}
