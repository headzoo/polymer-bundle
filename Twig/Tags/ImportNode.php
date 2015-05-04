<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\TwigConfigurationInterface;
use Twig_Node_Expression_Array;
use Twig_Node_Expression;
use Twig_Node;
use Twig_Compiler;

/**
 * Represents a `polymer_import` node.
 */
class ImportNode
    extends Twig_Node
{
    /**
     * Constructor
     *
     * @param Twig_Node_Expression[] $assets
     * @param int                    $lineno
     * @param string                 $tag
     */
    public function __construct(array $assets, $lineno, $tag)
    {
        parent::__construct([], ["assets" => $assets], $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $template = TwigConfigurationInterface::TEMPLATE_IMPORT;
        $assets   = $this->getAttribute("assets");
        $is_array = isset($assets[0]) && ($assets[0] instanceof Twig_Node_Expression_Array);
        
        $compiler
            ->addDebugInfo($this)
            ->write('$tmp = ["polymer_assets" => ');
        if (!$is_array) {
            $compiler
                ->raw("\n")
                ->indent()
                ->write('[');
        }
        
        $compiler
            ->raw("\n")
            ->indent();
        
        foreach ($this->getAttribute("assets") as $file_name) {
            $compiler
                ->subcompile($file_name, false)
                ->raw(",\n");
        }
        
        if (!$is_array) {
            $compiler
                ->outdent()
                ->write(']');
        }
        
        $compiler
            ->outdent()
            ->raw("\n")
            ->write('];')
            ->raw("\n")
            ->write('$template = $context["polymer"]["configuration"]->getTwig()->getTemplate(')
            ->string($template)
            ->raw(');')
            ->raw("\n\n")
            ->write('$this->env->display($template, $tmp);')
            ->raw("\n");
    }
}