<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Interface for Polymer configuration classes.
 */
interface PolymerConfigurationInterface
    extends ArrayConfigurationInterface
{
    const KEY_TWIG          = "twig";
    const KEY_PATHS         = "paths";
    const KEY_AUTO_IMPORTS  = "auto_imports";
    const KEY_AUTO_VERBATIM = "auto_verbatim";
    const KEY_DEBUG         = "debug";
    
    const DEFAULT_AUTO_VERBATIM = true;
    const DEFAULT_DEBUG         = true;
    
    const ROUTE_IMPORT = "/_polymer/import";

    /**
     * Gets an array of elements to import automatically
     * 
     * @return array
     */
    public function getAutoImports();

    /**
     * Sets the list of elements to import automatically
     * 
     * @param array $imports
     *
     * @return $this
     */
    public function setAutoImports(array $imports);

    /**
     * Gets a boolean indicating whether auto_verbatim is turned on
     * 
     * @return bool
     */
    public function isAutoVerbatim();

    /**
     * Sets a boolean indicating whether auto_verbatim is turned on
     * 
     * @param bool $auto_verbatim
     *
     * @return $this
     */
    public function setAutoVerbatim($auto_verbatim);

    /**
     * Returns whether debugging is enabled
     * 
     * @return bool
     */
    public function isDebug();

    /**
     * Sets whether debugging is enabled
     * 
     * @param bool $debug
     *
     * @return $this
     */
    public function setDebug($debug);
    
    /**
     * Gets the Twig configuration
     * 
     * @return TwigConfigurationInterface
     */
    public function getTwig();

    /**
     * Sets the Twig configuration
     * 
     * @param TwigConfigurationInterface $twig
     *
     * @return $this
     */
    public function setTwig(TwigConfigurationInterface $twig);

    /**
     * Gets the file paths configuration
     * 
     * @return PathsConfigurationInterface
     */
    public function getPaths();

    /**
     * Sets the file paths configuration
     * 
     * @param PathsConfigurationInterface $paths
     *
     * @return $this
     */
    public function setPaths(PathsConfigurationInterface $paths);
}