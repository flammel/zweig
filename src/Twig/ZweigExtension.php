<?php

namespace Flammel\Zweig\Twig;

use Flammel\Zweig\Twig\NodeVisitor\ZweigSlotMethodNodeVisitor;
use Flammel\Zweig\Twig\TokenParser\ComponentTokenParser;
use Flammel\Zweig\Twig\TokenParser\SlotTokenParser;
use Flammel\Zweig\Renderer\ComponentRenderer;
use Twig\Extension\ExtensionInterface;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class ZweigExtension implements ExtensionInterface
{
    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return TokenParserInterface[]
     */
    public function getTokenParsers()
    {
        return [
            new ComponentTokenParser(),
            new SlotTokenParser()
        ];
    }

    /**
     * Returns the node visitor instances to add to the existing list.
     *
     * @return NodeVisitorInterface[]
     */
    public function getNodeVisitors()
    {
        return [
            new ZweigSlotMethodNodeVisitor(),
        ];
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [];
    }

    /**
     * Returns a list of tests to add to the existing list.
     *
     * @return TwigTest[]
     */
    public function getTests()
    {
        return [];
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'component',
                [ZweigRuntimeExtension::class, 'componentFunction'],
                ['is_variadic' => true]
            )
        ];
    }

    /**
     * Returns a list of operators to add to the existing list.
     *
     * @return array<array> First array of unary operators, second array of binary operators
     */
    public function getOperators()
    {
        return [];
    }
}
