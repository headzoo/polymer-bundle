<?php
namespace Headzoo\Bundle\PolymerBundle\Util;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Resolves paths to component urls.
 */
class WebPathResolver
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
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
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
    public function getPrefix($bundle_name)
    {
        $elements_path = $this->configuration->getPaths()->getElements();
        $resource_path = "/Resources/public/{$elements_path}";
        $bundle        = $this->kernel->getBundle($bundle_name);
        
        if (!is_dir($bundle->getPath() . $resource_path)) {
            throw new Exception\PathNotFoundException(sprintf(
                'Bundle "%s" does not have "%s" folder',
                $bundle->getName(),
                $resource_path
            ));
        }

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
    public function getPath($bundle_name, $file_name)
    {
        $prefix = $this->getPrefix($bundle_name);
        $elements_path = $this->configuration->getPaths()->getElements();
        
        return sprintf('%s/%s/%s', $prefix, $elements_path, $file_name);
    }
}