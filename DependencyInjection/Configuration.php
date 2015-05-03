<?php
namespace Headzoo\Bundle\PolymerBundle\DependencyInjection;

use Headzoo\Bundle\PolymerBundle\Config\PathsConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\TwigConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration
    implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('polymer');
        
        $this->parseImports($rootNode);
        $this->parseTwig($rootNode);
        $this->parsePaths($rootNode);

        return $treeBuilder;
    }

    /**
     * Parse the imports configuration
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function parseImports($rootNode)
    {
        $rootNode->children()
            ->booleanNode(PolymerConfiguration::KEY_DEBUG)
                ->defaultValue(PolymerConfiguration::getDefault(PolymerConfiguration::KEY_DEBUG))
            ->end()
            ->booleanNode(PolymerConfiguration::KEY_USE_CONTROLLER)
                ->defaultValue(PolymerConfiguration::getDefault(PolymerConfiguration::KEY_USE_CONTROLLER))
            ->end()
            ->booleanNode(PolymerConfiguration::KEY_AUTO_VERBATIM)
                ->defaultValue(PolymerConfiguration::getDefault(PolymerConfiguration::KEY_AUTO_VERBATIM))
            ->end()
            ->arrayNode(PolymerConfiguration::KEY_IMPORTS)
                    ->prototype("scalar")
                    ->defaultValue(PolymerConfiguration::getDefault(PolymerConfiguration::KEY_IMPORTS))
                ->end()
            ->end();
    }

    /**
     * Parse the Twig configuration
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function parseTwig($rootNode)
    {
        $rootNode->children()
            ->arrayNode(PolymerConfiguration::KEY_TWIG)
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode(TwigConfiguration::KEY_TEMPLATES)
                        ->prototype("scalar")
                        ->defaultValue(TwigConfiguration::getDefault(TwigConfiguration::KEY_TEMPLATES))
                        ->end()
                    ->end()
                    ->scalarNode(TwigConfiguration::KEY_TAG)
                        ->defaultValue(TwigConfiguration::getDefault(TwigConfiguration::KEY_TAG))
                        ->end()
                ->end()
            ->end();
    }

    /**
     * Parse the paths configuration
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function parsePaths($rootNode)
    {
        $rootNode->children()
            ->arrayNode(PolymerConfiguration::KEY_PATHS)
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode(PathsConfiguration::KEY_ELEMENTS)
                        ->defaultValue(PathsConfiguration::getDefault(PathsConfiguration::KEY_ELEMENTS))
                        ->end()
                    ->scalarNode(PathsConfiguration::KEY_COMPONENTS)
                        ->defaultValue(PathsConfiguration::getDefault(PathsConfiguration::KEY_COMPONENTS))
                        ->end()
                ->end()
            ->end();
    }
}
