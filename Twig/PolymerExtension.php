<?php
namespace Headzoo\Bundle\PolymerBundle\Twig;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Twig_TokenParserInterface;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

/**
 * The Polymer Twig extension.
 */
class PolymerExtension
    extends Twig_Extension
    implements PolymerConfigurationAwareInterface
{
    use PolymerConfigurationAwareTrait;

    /**
     * @var Twig_SimpleFunction[]
     */
    private $functions = [];

    /**
     * @var Twig_SimpleFilter[]
     */
    private $filters = [];

    /**
     * @var Twig_TokenParserInterface
     */
    private $token_parsers = [];

    /**
     * Adds an object which contains exported functions
     * 
     * @param Functions\FunctionProviderInterface $functions
     */
    public function addFunctions(Functions\FunctionProviderInterface $functions)
    {
        foreach($functions->getFunctions() as $name => $callable) {
            $this->functions[] = new Twig_SimpleFunction(
                $this->configuration->getTwig()->getTag() . "_{$name}",
                $callable
            );
        }
    }

    /**
     * Adds an object which contains exported filters
     * 
     * @param Filters\FilterProviderInterface $filters
     */
    public function addFilters(Filters\FilterProviderInterface $filters)
    {
        foreach($filters->getFilters() as $name => $callable) {
            $this->filters[] = new Twig_SimpleFilter(
                $this->configuration->getTwig()->getTag() . "_{$name}",
                $callable
            );
        }
    }

    /**
     * Adds an object used to parse Polymer tags
     * 
     * @param Twig_TokenParserInterface $token_parser
     */
    public function addTokenParser(Twig_TokenParserInterface $token_parser)
    {
        $this->token_parsers[] = $token_parser;
    }

    /**
     * Returns a list of extension functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * Returns a list of extension filters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances
     */
    public function getTokenParsers()
    {
        return $this->token_parsers;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            "polymer" => [
                "configuration" => $this->configuration
            ]
        ];
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "polymer_extension";
    }
}