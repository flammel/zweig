<?php

namespace Flammel\Zweig\Twig\NodeVisitor;

use Flammel\Zweig\Twig\Node\ComponentNode;
use Flammel\Zweig\Twig\Node\SlotsMethodNode;
use Twig\Environment;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;

class ZweigSlotMethodNodeVisitor implements NodeVisitorInterface
{
    /**
     * @var ComponentNode[]
     */
    private $components = [];

    /**
     * Called before child nodes are visited.
     *
     * @param Node $node
     * @param Environment $env
     * @return Node The modified node
     */
    public function enterNode(Node $node, Environment $env): Node
    {
        if ($node instanceof ModuleNode) {
            $this->components = [];
        }
        if ($node instanceof ComponentNode) {
            $this->components[] = $node;
        }
        return $node;
    }

    /**
     * Called after child nodes are visited.
     *
     * @param Node $node
     * @param Environment $env
     * @return Node|null The modified node or null if the node must be removed
     */
    public function leaveNode(Node $node, Environment $env): ?Node
    {
        if ($node instanceof ModuleNode) {
            $node->setNode('class_end', new SlotsMethodNode(['components' => new Node($this->components)]));
            $this->components = [];
        }
        return $node;
    }

    /**
     * Returns the priority for this visitor.
     *
     * Priority should be between -10 and 10 (0 is the default).
     *
     * @return int The priority level
     */
    public function getPriority()
    {
        return 0;
    }
}
