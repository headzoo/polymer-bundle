<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Interface for classes which need the Polymer configuration.
 */
interface PolymerConfigurationAwareInterface
{
    /**
     * Sets the Polymer configuration
     *
     * @param PolymerConfigurationInterface $configuration
     */
    public function setConfiguration(PolymerConfigurationInterface $configuration);

    /**
     * Gets the Polymer configuration
     *
     * @return PolymerConfigurationInterface
     */
    public function getConfiguration();
}