<?php

namespace Flammel\Zweig\Twig\Node;

use Flammel\Zweig\Twig\ZweigExtension;
use Flammel\Zweig\Twig\ZweigRuntimeExtension;
use Twig\Compiler;
use Twig\Node\Node;

class ComponentNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->write('$extension = $this->env->getRuntime(')->string(ZweigRuntimeExtension::class)->raw(');')
            ->raw(PHP_EOL);
        $compiler->write('$renderer = $extension->getComponentRenderer();')->raw(PHP_EOL);
        $compiler->write('$name = ')->subcompile($this->getNode('name'))->raw(';')->raw(PHP_EOL);
        $compiler->write('$lineno = ')->string($this->lineno)->raw(';')->raw(PHP_EOL);
        $compiler->write('$props = ')->subcompile($this->getNode('props'))->raw(';')->raw(PHP_EOL);
        $compiler->write('$fills = [');
        /** @var FillNode $fill */
        foreach ($this->getNode('fills') as $fill) {
            $compiler->subcompile($fill->getNode('name'))->raw(',');
        }
        $compiler->raw('];')->raw(PHP_EOL);
        $compiler->write('echo $renderer->renderComponent($name, $lineno, $props, $fills, $context, $this);')
            ->raw(PHP_EOL);
    }
}
