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