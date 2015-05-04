<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Twig_Error_Syntax;
use Twig_Token;
use Twig_TokenParser;

/**
 * Token parser for the `polymer` tag.
 */
class PolymerTokenParser
    extends Twig_TokenParser
    implements PolymerConfigurationAwareInterface
{
    use PolymerConfigurationAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return $this->configuration->getTwig()->getTag();
    }
    
    /**
     * {@inheritdoc}
     */
    public function parse(Twig_Token $token)
    {
        $stream = $this->parser->getStream();
        if ($stream->nextIf(Twig_Token::NAME_TYPE, "import")) {
            return $this->parseImport($token);
        } else if ($stream->nextIf(Twig_Token::NAME_TYPE, "element")) {
            return $this->parseElement($token);
        } else {
            throw new Twig_Error_Syntax(sprintf(
                'Unexpected value.'
            ));
        }
    }

    /**
     * @param Twig_Token $token
     *
     * @return ImportNode
     * @throws Twig_Error_Syntax
     */
    public function parseImport(Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $assets = [];

        while(true) {
            $assets[] = $this->parser->getExpressionParser()->parseExpression();
            if ($stream->nextIf(Twig_Token::BLOCK_END_TYPE)) {
                break;
            } else if ($next = $stream->look(0)) {
                $type = $next->getType();
                if ($type !== Twig_Token::STRING_TYPE && $type !== Twig_Token::NAME_TYPE) {
                    throw new Twig_Error_Syntax(sprintf(
                        'Unexpected token "%s". Expected STRING_TYPE.',
                        $next->getValue()
                    ), $lineno, $stream->getFilename());
                }
            }
        }

        return new ImportNode($assets, $lineno, $this->getTag());
    }

    /**
     * @param Twig_Token $token
     *
     * @return ElementNode
     * @throws Twig_Error_Syntax
     */
    public function parseElement(Twig_Token $token)
    {
        $lineno       = $token->getLine();
        $stream       = $this->parser->getStream();
        $element_name = $stream->expect(Twig_Token::STRING_TYPE);
        $attributes   = [];

        $end = false;
        while (!$end) {
            $token = $stream->next();
            switch ($token->getType()) {
                case Twig_Token::BLOCK_END_TYPE:
                    $end = true;
                    break;

                case Twig_Token::NAME_TYPE:
                    $attr_name = $token->getValue();
                    if ($stream->test(Twig_Token::OPERATOR_TYPE, "=")) {
                        $stream->next();
                        $attr_value = $stream->expect(Twig_Token::STRING_TYPE);
                    } else {
                        $attr_value = new Twig_Token(Twig_Token::STRING_TYPE, "", $lineno);
                    }
                    $attributes[$attr_name] = $attr_value;
                    break;

                default:
                    throw new \Twig_Error_Syntax(sprintf(
                        'Unexpected token "%s".',
                        $token->getValue()
                    ), $lineno, $stream->getFilename());
                    break;
            }
        }

        $body = $this->parser->subparse([$this, "decideElementEnd"], true);
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new ElementNode($element_name, $body, $attributes, $lineno, $this->getTag());
    }

    /**
     * Parser callback to find the end of the element block
     *
     * @param Twig_Token $token
     *
     * @return bool
     */
    public function decideElementEnd(Twig_Token $token)
    {
        return $token->test("end" . $this->getTag());
    }
}