<?php

namespace Flammel\Zweig\Twig\TokenParser;

use Flammel\Zweig\Twig\Node\ComponentNode;
use Flammel\Zweig\Twig\Node\FillNode;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class ComponentTokenParser extends AbstractTokenParser
{
    /**
     * @param Token $token
     * @return \Flammel\Zweig\Twig\Node\ComponentNode|Node
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $stream = $this->parser->getStream();
        $props = new ArrayExpression([], $lineno);
        if ($stream->nextIf(Token::NAME_TYPE, 'with')) {
            $props = $this->parser->getExpressionParser()->parseExpression();
        }
        $fills = [];
        $stream->expect(Token::BLOCK_END_TYPE);
        $this->parser->subparse([$this, 'decideComponentFork']);
        $end = false;
        while (!$end) {
            switch ($stream->next()->getValue()) {
                case 'fill':
                    $name = $this->parser->getExpressionParser()->parseExpression();
                    $stream->expect(Token::BLOCK_END_TYPE);
                    $fills[] = new FillNode(
                        $name,
                        $this->parser->subparse([$this, 'decideComponentFork']),
                        $stream->getCurrent()->getLine(),
                        $stream->getCurrent()
                    );
                    break;
                case 'endfill':
                    $stream->expect(Token::BLOCK_END_TYPE);
                    $this->parser->subparse([$this, 'decideComponentFork']);
                    break;
                case 'endcomponent':
                    $end = true;
                    break;
                default:
                    throw new SyntaxError(
                        sprintf(
                            'Unexpected end of template. ' .
                            'Twig was looking for the following tag "fill", "endfill", or "endcomponent" to close ' .
                            'the "component" block started at line %d).',
                            $lineno
                        ),
                        $stream->getCurrent()->getLine()
                    );
            }
        }
        $stream->expect(Token::BLOCK_END_TYPE);
        return new ComponentNode(
            [
                'props' => $props,
                'name' => $expr,
                'fills' => new Node($fills)
            ],
            [],
            $lineno,
            $this->getTag()
        );
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'component';
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideComponentFork(Token $token)
    {
        return $token->test(['fill', 'endfill', 'endcomponent']);
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideComponentEnd(Token $token)
    {
        return $token->test('endcomponent');
    }
}
