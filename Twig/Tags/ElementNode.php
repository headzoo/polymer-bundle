<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\TwigConfigurationInterface;
use Twig_NodeTraverser;
use Twig_Node;
use Twig_Token;
use Twig_Compiler;

/**
 * Represents a `polymer_element` node.
 */
class ElementNode
    extends Twig_Node
{
    /**
     * @var Twig_Token
     */
    private $_element_name;

    /**
     * @var Twig_Token[]
     */
    private $_attributes = [];

    /**
     * Constructor
     *
     * @param Twig_Token   $element_name
     * @param Twig_Node    $body
     * @param Twig_Token[] $attributes
     * @param int          $lineno
     * @param string       $tag
     */
    public function __construct(Twig_Token $element_name, Twig_Node $body, array $attributes, $lineno, $tag)
    {
        parent::__construct(["body" => $body], $attributes, $lineno, $tag);
        $this->_element_name = $element_name;
        $this->_attributes   = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $attributes = [];
        foreach ($this->_attributes as $name => $attr) {
            $name              = str_replace("on_", "on-", $name);
            $attributes[$name] = $attr->getValue();
        }

        $element_name       = $this->_element_name->getValue();
        $element_name_clean = preg_replace('/[^\w]/i', '_', $element_name);
        $body_func          = sprintf('$body_%s', $element_name_clean);
        $template           = TwigConfigurationInterface::TEMPLATE_ELEMENT;
        
        $compiler
            ->addDebugInfo($this)
            ->write($body_func . ' = function() use($context) {')
            ->raw("\n")
            ->indent();
        
        $compiler
            ->write('ob_start();')
            ->subcompile($this->getNode("body"))
            ->write('$tmp = ob_get_contents();')
            ->raw("\n")
            ->write('ob_end_clean();')
            ->raw("\n\n")
            ->write('return $tmp;')
            ->raw("\n")
            ->outdent()
            ->write('};')
            ->raw("\n\n");

        $compiler
            ->addDebugInfo($this)
            ->write('$tmp = [')
            ->raw("\n")
            ->indent()
            ->write('"polymer_body" => ')
            ->raw($body_func . '(),')
            ->raw("\n")
            ->write('"polymer_element_name" => ')
            ->string($element_name)
            ->raw(",\n")
            ->write('"polymer_attributes" => ')
            ->repr($attributes)
            ->raw(",\n")
            ->outdent()
            ->write('];')
            ->raw("\n\n");

        $compiler
            ->write('$template = $context["polymer"]["configuration"]->getTwig()->getTemplate(')
            ->string($template)
            ->raw(');')
            ->write('$this->env->display($template, $tmp);')
            ->raw("\n");
    }
}