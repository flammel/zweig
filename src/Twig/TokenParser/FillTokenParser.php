<?php

namespace Flammel\Zweig\Twig\TokenParser;

use Flammel\Zweig\Twig\Node\FillNode;
use Twig\Error\SyntaxError;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class FillTokenParser extends AbstractTokenParser
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
        $stream->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideFillEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);
        return new FillNode($name, $body, $lineno, $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'fill';
    }

    /**
     * @param Token $token
     * @return bool
     */
    public function decideFillEnd(Token $token)
    {
        return $token->test('endfill');
    }
}
