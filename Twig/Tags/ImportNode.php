<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\TwigConfigurationInterface;
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
        
            $compiler
                ->addDebugInfo($this)
                ->write('$tmp = ["polymer_assets" => [')
                ->raw("\n")
                ->indent();
        
            foreach ($this->getAttribute("assets") as $file_name) {
                $compiler
                    ->subcompile($file_name, false)
                    ->raw(",\n");
            }
        
            $compiler
                ->outdent()
                ->write(']];')
                ->raw("\n")
                ->write('$template = $context["polymer"]["configuration"]->getTwig()->getTemplate(')
                ->string($template)
                ->raw(');')
                ->raw("\n\n")
                ->write('$this->env->display($template, $tmp);')
                ->raw("\n");
    }
}