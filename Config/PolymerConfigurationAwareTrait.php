<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Implements the PolymerConfigAwareInterface interface.
 */
trait PolymerConfigurationAwareTrait
{
    /**
     * @var PolymerConfigurationInterface
     */
    protected $configuration;
    
    /**
     * Sets the Polymer configuration
     *
     * @param PolymerConfigurationInterface $configuration
     */
    public function setConfiguration(PolymerConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Gets the Polymer configuration
     *
     * @return PolymerConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}