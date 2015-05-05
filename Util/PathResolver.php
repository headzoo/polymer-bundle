<?php
namespace Headzoo\Bundle\PolymerBundle\Util;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationInterface;
use Headzoo\Bundle\PolymerBundle\Exception\RuntimeException;
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
     * Returns the path that multiple directories have in common
     *
     * @see http://rosettacode.org/wiki/Find_common_directory_path#PHP
     *
     * @param array $directories
     *
     * @return string
     */
    public function findCommonPath(array $directories)
    {
        $arr = [];
        foreach ($directories as $i => $path) {
            $directories[$i] = explode("/", $path);
            unset($directories[$i][0]);
            $arr[$i] = count($directories[$i]);
        }

        $min = min($arr);
        for ($i = 0; $i < count($directories); $i++) {
            while (count($directories[$i]) > $min) {
                array_pop($directories[$i]);
            }

            $directories[$i] = "/" . implode("/", $directories[$i]);
        }

        $directories = array_unique($directories);
        while (count($directories) !== 1) {
            $directories = array_map("dirname", $directories);
            $directories = array_unique($directories);
        }
        reset($directories);

        return current($directories);
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
     * @param string $asset       The name of the file
     *
     * @return string
     */
    public function getBundleWebPath($bundle_name, $asset)
    {
        $prefix        = $this->getBundleWebPrefix($bundle_name);
        $elements_path = $this->configuration->getPaths()->getElements();

        return sprintf('%s/%s/%s', $prefix, $elements_path, $asset);
    }

    /**
     * Get relative path
     *
     * @param string $bundle_name The name of the bundle
     * @param string $asset       The name of the file
     *
     * @return string
     * @throws RuntimeException
     */
    public function getBundleRelativeWebPath($bundle_name, $asset)
    {
        $elements_path = $this->configuration->getPaths()->getElements();
        $root_path     = $this->kernel->getRootDir();
        $bundle_path   = $this->kernel->getBundle($bundle_name)->getPath();
        $common_path   = $this->findCommonPath([$root_path, $bundle_path]);
        if (!$common_path || strpos($bundle_path, $common_path) !== 0) {
            throw new RuntimeException(
                'Could not determine path to the src/ directory.'
            );
        }

        $bundle_path = ltrim(substr($bundle_path, strlen($common_path)), '/');

        return "/../{$bundle_path}/Resources/public/{$elements_path}/{$asset}";
    }

    /**
     * Returns the import url for a custom element or component
     *
     * @param string $asset The name of the element/component file
     *
     * @return string
     */
    public function getImportUrl($asset)
    {
        if (preg_match('/@([\w]+):(.*)/i', $asset, $matches)) {
            return $this->getBundleImportUrl($matches[1], $matches[2]);
        } else {
            return $this->getComponentImportUrl($asset);
        }
    }

    /**
     * Returns the import url for a custom element
     *
     * @param string $bundle_name The name of the bundle
     * @param string $asset       The name of the element file
     *
     * @return string
     * @throws RuntimeException
     */
    protected function getBundleImportUrl($bundle_name, $asset)
    {
        $dirname = pathinfo($asset, PATHINFO_DIRNAME);
        if ($dirname === ".") {
            list($path) = explode(".", $asset, 2);
            $asset = "{$path}/{$asset}";
        }

        if ($this->configuration->isDebug()) {
            if ($this->configuration->getPaths()->isRelativeOnDebug()) {
                $url = $this->getBundleRelativeWebPath($bundle_name, $asset);
            } else {
                $url = PolymerConfiguration::ROUTE_IMPORT . "?bundle={$bundle_name}&element=" . urlencode($asset);
            }
        } else {
            if (substr($asset, -10) === ".html.twig") {
                $asset = substr($asset, 0, -5);
            }
            $url = $this->getBundleWebPath($bundle_name, $asset);
        }

        return $url;
    }

    /**
     * Returns the import url for a component
     *
     * @param string $asset The name of the component file
     *
     * @return string
     */
    protected function getComponentImportUrl($asset)
    {
        if ($asset[0] === "/" || strpos($asset, "http") === 0) {
            $url = $asset;
        } else {
            $dirname = pathinfo($asset, PATHINFO_DIRNAME);
            if ($dirname === ".") {
                list($path) = explode(".", $asset, 2);
                $asset = "{$path}/{$asset}";
            }

            $root = $this->configuration->getPaths()->getComponents();
            $url  = sprintf(
                "/%s/%s",
                $root,
                $asset
            );
        }

        return $url;
    }
}