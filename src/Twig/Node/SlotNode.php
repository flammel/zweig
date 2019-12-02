<?php

namespace Flammel\Zweig\Twig\Node;

use Flammel\Zweig\Twig\ZweigExtension;
use Flammel\Zweig\Twig\ZweigRuntimeExtension;
use Twig\Compiler;
use Twig\Node\Node;

class SlotNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->write('$extension = $this->env->getRuntime(')->string(ZweigRuntimeExtension::class)->raw(');')
            ->raw(PHP_EOL);
        $compiler->write('$renderer = $extension->getComponentRenderer();')->raw(PHP_EOL);
        $compiler->write('$name = ')->subcompile($this->getNode('name'))->raw(';')->raw(PHP_EOL);
        $compiler->write('if ($renderer->fills($name)) {')->raw(PHP_EOL)
            ->indent()
            ->write('$contextForFill = ')->subcompile($this->getNode('expose'))->raw(';')->raw(PHP_EOL)
            ->raw('echo $renderer->getFill($name, $contextForFill);')->raw(PHP_EOL)
            ->outdent()
            ->raw('} else {')->raw(PHP_EOL)
            ->indent()
            ->subCompile($this->getNode('body'))->raw(PHP_EOL)
            ->outdent()
            ->raw('}')->raw(PHP_EOL);
    }
}
