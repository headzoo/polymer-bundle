<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\TwigConfigurationInterface;
use Twig_Node_Expression;
use Twig_Node;
use Twig_Token;
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
     * @param Twig_Node_Expression[] $file_names
     * @param Twig_Token             $file_type
     * @param int                    $lineno
     * @param string                 $tag
     */
    public function __construct(array $file_names, Twig_Token $file_type, $lineno, $tag)
    {
        parent::__construct([], ["file_names" => $file_names, "file_type" => $file_type], $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $template = TwigConfigurationInterface::TEMPLATE_IMPORT;
        foreach ($this->getAttribute("file_names") as $file_name) {
            $compiler
                ->addDebugInfo($this)
                ->write('$tmp = ["polymer_asset_name" => ')
                ->subcompile($file_name)
                ->raw('];')
                ->raw("\n")
                ->write('$template = $context["polymer"]["configuration"]->getTwig()->getTemplate(')
                ->string($template)
                ->raw(');')
                ->raw("\n\n")
                ->write('$this->env->display($template, $tmp);')
                ->raw("\n");
        }

    }
}