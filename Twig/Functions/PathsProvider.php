<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Functions;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;
use Headzoo\Bundle\PolymerBundle\Util\PathResolver;

/**
 * Polymer paths and urls related Twig functions.
 */
class PathsProvider
    implements FunctionProviderInterface
{
    use PolymerConfigurationAwareTrait;
    
    /**
     * @var PathResolver
     */
    private $web_path_resolver;

    /**
     * Constructor
     *
     * @param PathResolver $web_path_resolver
     */
    public function __construct(PathResolver $web_path_resolver)
    {
        $this->web_path_resolver = $web_path_resolver;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            "import_url" => [$this, "getImportUrl"]
        ];
    }

    /**
     * Returns an element url
     *
     * Examples:
     * ```php
     *
     * $this->getImportUrl("hello-world")
     * $this->getImportUrl("hello-world.html")
     * $this->getImportUrl("hello-world.html.twig")
     * $this->getImportUrl("/hello-world.html")
     * $this->getImportUrl("/hello-world/hello-world.html")
     * $this->getImportUrl("/hello-world/hello-world.html.twig")
     *
     * ```
     *
     * @param string $file_name The name of the asset
     *
     * @return string
     */
    public function getImportUrl($file_name)
    {
        return $this->buildAssetPath($file_name);
    }

    /**
     * Builds a full path for an element or component
     *
     * @param string $file_name The name of the file
     *
     * @return string
     */
    private function buildAssetPath($file_name)
    {
        $info = pathinfo($file_name);
        if (empty($info["extension"])) {
            $file_name .= ".html";
        }
        
        if ($file_name[0] === "@") {
            if ($info["dirname"] === ".") {
                list($bundle, $base_name) = explode(":", $file_name, 2);
                list($path) = explode(".", $base_name, 2);
                $file_name = "{$bundle}:{$path}/{$base_name}";
            }
            
            if ($this->configuration->getDebug() && $this->configuration->getUseController()) {
                $url = PolymerConfiguration::ROUTE_IMPORT . "?element=" . urlencode($file_name);
            } else {
                $url = $this->getBundledElementUrl($file_name);
            }
        } else {
            $root = $this->configuration->getPaths()->getComponents();
            
            // "/paper-elements"
            // "/paper-elements.html"
            // "/paper-elements/paper-elements.html"
            if ($file_name[0] === "/") {
                $url = sprintf(
                    "/%s%s",
                    $root,
                    $file_name
                );

                // "paper-elements"
                // "paper-elements.html"
            } else {
                $url = sprintf(
                    "/%s/%s/%s",
                    $root,
                    explode(".", $file_name, 2)[0],
                    $file_name
                );
            }
        }
        
        return $url;
    }

    /**
     * Returns the relative url for the given file
     * 
     * @param string $file_name
     *
     * @return string
     */
    private function getBundledElementUrl($file_name)
    {
        // "@PolymerBundle:hello-world/hello-world.html.twig"
        $parts = explode(":", substr($file_name, 1), 2);
        
        return $this->web_path_resolver->getBundleWebPath($parts[0], $parts[1]);
    }
}