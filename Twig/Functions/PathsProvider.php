<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Functions;

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
    private $path_resolver;

    /**
     * Constructor
     *
     * @param PathResolver $path_resolver
     */
    public function __construct(PathResolver $path_resolver)
    {
        $this->path_resolver = $path_resolver;
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
     * Returns an element or component url
     *
     * @param string $file_name The name of the element/component
     *
     * @return string
     */
    public function getImportUrl($file_name)
    {
        return $this->path_resolver->getImportUrl($file_name);
    }
}