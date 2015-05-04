<?php
namespace Headzoo\Bundle\PolymerBundle\Util;

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
}