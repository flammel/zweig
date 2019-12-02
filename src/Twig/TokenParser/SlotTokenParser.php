<?php

namespace Flammel\Zweig\Twig\TokenParser;

use Flammel\Zweig\Twig\Node\SlotNode;
use Twig\Error\SyntaxError;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class SlotTokenParser extends AbstractTokenParser
{
    /**
     * @param Token $token
     * @return Node
     * @throws SyntaxError
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $this->parser->getExpressionParser()->parseExpression();
        $expose = new ArrayExpression([], $lineno);
        $next = $stream->next();
        if ($next->getValue() === 'expose') {
            $expose = $this->parser->getExpressionParser()->parseExpression();
            $stream->expect(Token::BLOCK_END_TYPE);
        }
        $body = $this->parser->subparse([$this, 'decideSlotEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);
        return new SlotNode(['body' => $body, 'expose' => $expose, 'name' => $name], [], $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'slot';
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideSlotEnd(Token $token)
    {
        return $token->test('endslot');
    }
}
