<?php
namespace Headzoo\Bundle\PolymerBundle\Util;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Resolves paths to component urls.
 */
class PathResolver
    implements PolymerConfigurationAwareInterface
{
    use PolymerConfigurationAwareTrait;
    
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * Constructor
     * 
     * @param PolymerConfigurationInterface $configuration
     * @param KernelInterface               $kernel
     */
    public function __construct(PolymerConfigurationInterface $configuration, KernelInterface $kernel)
    {
        $this->setConfiguration($configuration);
        $this->kernel = $kernel;
    }
    
    /**
     * Gets the prefix of the asset with the given bundle
     *
     * @param string $bundle_name The name of the bundle
     *
     * @return string Prefix
     * @throws Exception\PathNotFoundException
     */
    public function getBundleWebPrefix($bundle_name)
    {
        $bundle = $this->kernel->getBundle($bundle_name);

        return sprintf(
            "/bundles/%s",
            preg_replace('/bundle$/', "", strtolower($bundle->getName()))
        );
    }

    /**
     * Get path
     *
     * @param string $bundle_name The name of the bundle
     * @param string $file_name   The name of the file
     *
     * @return string
     */
    public function getBundleWebPath($bundle_name, $file_name)
    {
        $prefix = $this->getBundleWebPrefix($bundle_name);
        $elements_path = $this->configuration->getPaths()->getElements();
        
        return sprintf('%s/%s/%s', $prefix, $elements_path, $file_name);
    }

    /**
     * Builds a full path for an element or component
     *
     * @param string $file_name The name of the file
     *
     * @return string
     */
    public function getImportUrl($file_name)
    {
        $info = pathinfo($file_name);
        
        // "@AcmeBundle:hello-world.html.twig"
        // "@AcmeBundle:hello-world"
        // "@AcmeBundle:hello-world/hello-world.html.twig"
        if (preg_match('/@([\w]+):(.*)/i', $file_name, $matches)) {
            $bundle    = $matches[1];
            $file_name = $matches[2];
            if ($info["dirname"] === ".") {
                list($path) = explode(".", $file_name, 2);
                $file_name = "{$path}/{$file_name}";
            }

            if ($this->configuration->getDebug() && $this->configuration->getUseController()) {
                $url = PolymerConfiguration::ROUTE_IMPORT . "?bundle={$bundle}&element=" . urlencode($file_name);
            } else {
                if (substr($file_name, -10) === ".html.twig") {
                    $file_name = substr($file_name, 0, -5);
                }
                $url = $this->getBundleWebPath($bundle, $file_name);
            }
        } else {
            $root = $this->configuration->getPaths()->getComponents();

            // "/paper-elements"
            // "/paper-elements.html"
            // "/paper-elements/paper-elements.html"
            if ($file_name[0] === "/") {
                $url = $file_name;

            // "paper-elements"
            // "paper-elements.html"
            // "paper-elements/paper-elements.html"
            } else {
                if ($info["dirname"] === ".") {
                    list($path) = explode(".", $file_name, 2);
                    $file_name = "{$path}/{$file_name}";
                }
                
                $url = sprintf(
                    "/%s/%s",
                    $root,
                    $file_name
                );
            }
        }

        return $url;
    }
}