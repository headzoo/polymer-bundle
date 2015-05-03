<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Functions;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;

/**
 * Polymer paths and urls related Twig functions.
 */
class PathsProvider
    implements FunctionProviderInterface
{
    use PolymerConfigurationAwareTrait;
    
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
     * $this->getUrlElement("hello-world")
     * $this->getUrlElement("hello-world.html")
     * $this->getUrlElement("hello-world.html.twig")
     * $this->getUrlElement("/hello-world.html")
     * $this->getUrlElement("/hello-world/hello-world.html")
     * $this->getUrlElement("/hello-world/hello-world.html.twig")
     *
     * ```
     *
     * @param string $file_name The name of the asset
     * @param string $file_type The type of asset
     *
     * @return string
     */
    public function getImportUrl($file_name, $file_type)
    {
        return $this->buildAssetPath(
            $this->configuration->getPaths()->get($file_type),
            $file_name
        );
    }

    /**
     * Builds a full path for an element or component
     *
     * @param string $root      The root asset directory
     * @param string $file_name The name of the file
     *
     * @return string
     */
    private function buildAssetPath($root, $file_name)
    {
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        if (empty($extension)) {
            $file_name .= ".html";
        }

        // "/hello-world"
        // "/hello-world.html"
        // "/hello-world/hello-world.html"
        // "/hello-world/hello-world.html.twig"
        if ($file_name[0] === "/") {
            return sprintf(
                "%s%s",
                $root,
                $file_name
            );

            // "hello-world"
            // "hello-world.html"
            // "hello-world.html.twig"
        } else {
            return sprintf(
                "%s/%s/%s",
                $root,
                explode(".", $file_name, 2)[0],
                $file_name
            );
        }
    }
}