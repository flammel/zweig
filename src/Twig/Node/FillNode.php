<?php

namespace Flammel\Zweig\Twig\Node;

use Twig\Compiler;
use Twig\Node\Node;

class FillNode extends Node
{
    public function __construct(Node $name, Node $body, $lineno, $tag)
    {
        parent::__construct(['body' => $body, 'name' => $name], [], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        // Do nothing. Fills are compiled by SlotsMethodNode
    }
}
