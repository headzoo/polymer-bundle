<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Tags;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationInterface;
use Twig_Environment;
use Twig_Lexer;

/**
 * Twig lexer.
 * 
 * Overrides the default Twig lexer so that Polymer tags can be wrapped
 * in {% verbatim %} tags.
 */
class Lexer
    extends Twig_Lexer
    implements PolymerConfigurationAwareInterface
{
    use PolymerConfigurationAwareTrait;
    
    /**
     * @var array
     */
    protected $polymer_regexes = [];
    
    /**
     * Constructor
     * 
     * @param Twig_Environment              $env
     * @param array                         $options
     * @param PolymerConfigurationInterface $configuration
     */
    public function __construct(Twig_Environment $env, array $options = [], PolymerConfigurationInterface $configuration)
    {
        parent::__construct($env, $options);
        
        $element_start = $configuration->getTwig()->getTag();
        $element_end   = "end{$element_start}";
        $this->polymer_regexes["starts"]["element"] = '/({%\s*' . $element_start . '\s+element.*%})/i';
        $this->polymer_regexes["ends"]["element"]   = '/({%\s*' . $element_end . '\s*%})/i';
    }
    
    /**
     * {@inheritdoc}
     */
    public function tokenize($code, $filename = null)
    {
        foreach($this->polymer_regexes["starts"] as $regex) {
            $code = preg_replace($regex, '\\1{% verbatim %}', $code);
        }
        foreach($this->polymer_regexes["ends"] as $regex) {
            $code = preg_replace($regex, '{% endverbatim %}\\1', $code);
        }
        
        $code = str_replace("<twig>", '{% endverbatim %}', $code);
        $code = str_replace("</twig>", '{% verbatim %}', $code);
        
        return parent::tokenize($code, $filename);
    }
}