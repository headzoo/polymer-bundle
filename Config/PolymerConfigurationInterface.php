<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Interface for Polymer configuration classes.
 */
interface PolymerConfigurationInterface
    extends ArrayConfigurationInterface
{
    const KEY_TWIG = "twig";
    const KEY_PATHS = "paths";
    const KEY_IMPORTS = "imports";
    const KEY_AUTO_VERBATIM = "auto_verbatim";
    const KEY_DEBUG = "debug";
    const KEY_USE_CONTROLLER = "use_controller";
    
    const DEFAULT_AUTO_VERBATIM = true;
    const DEFAULT_DEBUG = false;
    const DEFAULT_USE_CONTROLLER = true;
    
    const ROUTE_IMPORT = "/_polymer/import";

    /**
     * Gets an array of elements to import automatically
     * 
     * @return array
     */
    public function getImports();

    /**
     * Sets the list of elements to import automatically
     * 
     * @param array $imports
     *
     * @return $this
     */
    public function setImports(array $imports);

    /**
     * Gets a boolean indicating whether auto_verbatim is turned on
     * 
     * @return bool
     */
    public function getAutoVerbatim();

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
    public function getDebug();

    /**
     * Sets whether debugging is enabled
     * 
     * @param bool $debug
     *
     * @return $this
     */
    public function setDebug($debug);

    /**
     * Gets whether the controller is used to resolve element urls
     * 
     * @return bool
     */
    public function getUseController();

    /**
     * Sets whether the controller is used to resolve element urls
     * 
     * @param bool $use_controller
     *
     * @return $this
     */
    public function setUseController($use_controller);
    
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