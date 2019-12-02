<?php

namespace Flammel\Zweig\Twig\Node;

use Twig\Compiler;
use Twig\Node\Node;

class SlotsMethodNode extends Node
{
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        $compiler->write('public function getFill($cname, $lineno, $fname, $context) {')->raw(PHP_EOL)->indent();
        $compiler->write('$blocks = [];')->raw(PHP_EOL);
        $components = $this->getNode('components');
        /** @var ComponentNode $component */
        foreach ($components as $component) {
            $fills = $component->getNode('fills');
            /** @var FillNode $fill */
            foreach ($fills as $fill) {
                $compiler->write('$c = ')->subcompile($component->getNode('name'))->raw(';')->raw(PHP_EOL);
                $compiler->write('$l = ')->string($component->lineno)->raw(';')->raw(PHP_EOL);
                $compiler->write('$f = ')->subcompile($fill->getNode('name'))->raw(';')->raw(PHP_EOL);
                $compiler->write('if ($c === $cname && $l === $lineno && $f === $fname) {')->raw(PHP_EOL)->indent();
                $compiler->subcompile($fill->getNode('body'));
                $compiler->outdent()->write('}')->raw(PHP_EOL);
            }
        }
        $compiler->outdent()->write('}')->raw(PHP_EOL);
    }
}
