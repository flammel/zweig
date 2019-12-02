<?php

namespace Flammel\Zweig\Twig;

use Flammel\Zweig\Renderer\ComponentRenderer;
use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Component\ComponentName;

class ZweigRuntimeExtension
{
    /**
     * @var ComponentRenderer
     */
    private $componentRenderer;

    /**
     * @param ComponentRenderer $componentRenderer
     */
    public function __construct(ComponentRenderer $componentRenderer)
    {
        $this->componentRenderer = $componentRenderer;
    }

    /**
     * @return ComponentRenderer
     */
    public function getComponentRenderer(): ComponentRenderer
    {
        return $this->componentRenderer;
    }

    /**
     * @param mixed $name
     * @param mixed ...$props
     * @return string
     * @throws \Flammel\Zweig\Exception\ZweigException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function componentFunction($name, ...$props)
    {
        return $this->componentRenderer->render(
            new ComponentName($name),
            new ComponentArguments($props)
        );
    }

    /**
     * @param array $context
     * @param mixed ...$names
     */
    public function propsFunction(array $context, ...$names)
    {
        foreach ($context as $key => $value) {
            if (method_exists($value, 'setPropNames')) {
                $value->setPropNames($names);
            }
        }
    }
}
