<?php
namespace Headzoo\Bundle\PolymerBundle\DependencyInjection;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Twig\Tags\Environment;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PolymerExtension
    extends Extension
{
    /**
     * @var PolymerConfiguration
     */
    private $configuration;
    
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('twig.yml');
        
        $this->setupPolymerConfiguration($container, $config);
        $this->setupTaggedServices($container);
        $this->setupTwig($container);
    }

    /**
     * Overrides the polymer.configuration definition
     * 
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function setupPolymerConfiguration(ContainerBuilder $container, array $config)
    {
        $definition = new Definition();
        $definition->setClass(PolymerConfiguration::class);
        $definition->setArguments([$config]);
        $container->setDefinition("polymer.configuration", $definition);
        
        $this->configuration = $container->get("polymer.configuration");
    }

    /**
     * Initialize tagged services
     * 
     * @param ContainerBuilder $container
     */
    private function setupTaggedServices(ContainerBuilder $container)
    {
        $extension     = $container->getDefinition("polymer.twig.extension");
        $token_parsers = $container->findTaggedServiceIds("polymer.twig.token_parser");
        foreach($token_parsers as $service_id => $tags) {
            $extension->addMethodCall(
                "addTokenParser",
                [new Reference($service_id)]
            );
        }
        
        $functions = $container->findTaggedServiceIds("polymer.twig.function");
        foreach($functions as $service_id => $tags) {
            $extension->addMethodCall(
                "addFunctions",
                [new Reference($service_id)]
            );
        }

        $filters = $container->findTaggedServiceIds("polymer.twig.filter");
        foreach($filters as $service_id => $tags) {
            $extension->addMethodCall(
                "addFilters",
                [new Reference($service_id)]
            );
        }
    }

    /**
     * Initialize Twig configuration
     * 
     * @param ContainerBuilder $container
     */
    private function setupTwig(ContainerBuilder $container)
    {
        if ($this->configuration->isAutoVerbatim()) {
            $definition = new Definition();
            $definition->setClass(Environment::class);
            $definition->setArguments(
                [
                    new Reference("twig.loader"),
                    $container->getParameter("twig.options"),
                    new Reference("polymer.configuration")
                ]
            );
            $definition->addMethodCall(
                "addGlobal",
                [
                    "app",
                    new Reference("templating.globals")
                ]
            );

            $container->setDefinition("twig", $definition);
        }
    }
}
