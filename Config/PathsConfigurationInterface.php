<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Interface for Polymer file path configuration.
 */
interface PathsConfigurationInterface
    extends ArrayConfigurationInterface
{
    const DEFAULT_RELATIVE_ON_DEBUG = false;
    const DEFAULT_ELEMENTS          = "elements";
    const DEFAULT_COMPONENTS        = "bower_components";

    const KEY_RELATIVE_ON_DEBUG = "relative_on_debug";
    const KEY_ELEMENTS          = "elements";
    const KEY_COMPONENTS        = "components";

    /**
     * Returns a boolean indicating whether relative paths to custom elements
     * should be used when debugging.
     * 
     * @return bool
     */
    public function isRelativeOnDebug();

    /**
     * Sets the relative_on_debug setting
     * 
     * @param bool $relative_on_debug
     *
     * @return $this
     */
    public function setRelativeOnDebug($relative_on_debug);
    
    /**
     * Gets the path to the custom elements
     * 
     * @return string
     */
    public function getElements();

    /**
     * Sets the path to the custom elements
     * 
     * @param string $elements
     *
     * @return $this
     */
    public function setElements($elements);

    /**
     * Gets the path to the bower components
     * 
     * @return string
     */
    public function getComponents();

    /**
     * Sets the path to the bower components
     * 
     * @param string $components
     *
     * @return $this
     */
    public function setComponents($components);
}