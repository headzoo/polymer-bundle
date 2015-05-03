<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationInterface;
use Twig_Environment;
use Twig_LoaderInterface;

/**
 * Twig environment.
 * 
 * Overrides the built in environment to set our custom lexer.
 */
class Environment
    extends Twig_Environment
    implements PolymerConfigurationAwareInterface
{
    use PolymerConfigurationAwareTrait;

    /**
     * @var array
     */
    private $_options = [];
    
    /**
     * Constructor
     * 
     * @param Twig_LoaderInterface          $loader  A Twig_LoaderInterface instance
     * @param array                         $options An array of options
     * @param PolymerConfigurationInterface $configuration
     */
    public function __construct(Twig_LoaderInterface $loader = null, $options = array(), PolymerConfigurationInterface $configuration)
    {
        parent::__construct($loader, $options);
        
        $this->_options = $options;
        $this->setConfiguration($configuration);
    }
    
    /**
     * Gets the Lexer instance.
     *
     * @return \Twig_LexerInterface A Twig_LexerInterface instance
     */
    public function getLexer()
    {
        if (null === $this->lexer) {
            $this->lexer = new Lexer($this, $this->_options, $this->configuration);
        }

        return $this->lexer;
    }
}