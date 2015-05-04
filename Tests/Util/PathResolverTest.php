<?php
namespace Headzoo\Bundle\PolymerBundle\Tests\Util;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Util\PathResolver;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @coversDefaultClass \Headzoo\Bundle\PolymerBundle\Util\PathResolver
 */
class PathResolverTest
    extends KernelTestCase
{
    /**
     * @var PathResolver
     */
    protected $fixture;

    /**
     * @var PolymerConfiguration
     */
    protected $configuration;

    /**
     * Called before any of the tests are run
     */
    public static function setUpBeforeClass()
    {
        static::bootKernel();
    }

    /**
     * Called before each test is run
     */
    public function setUp()
    {
        $this->configuration = new PolymerConfiguration();
        $this->fixture = new PathResolver($this->configuration, static::$kernel);
    }

    /**
     * @covers ::getPrefix
     */
    public function testGetBundleWebPrefix()
    {
        $this->assertEquals(
            "/bundles/polymer",
            $this->fixture->getBundleWebPrefix("PolymerBundle")
        );
    }

    /**
     * @covers ::getPath
     */
    public function testGetBundleWebPath()
    {
        $elements_path = (new PolymerConfiguration())->getPaths()->getElements();
        $this->assertEquals(
            "/bundles/polymer/{$elements_path}/hello-world/hello-world.html",
            $this->fixture->getBundleWebPath("PolymerBundle", "hello-world/hello-world.html")
        );
    }

    /**
     * @dataProvider dataProviderGetImportUrl
     * 
     * @param string $asset
     * @param bool   $debug
     * @param bool   $use_controller
     * @param string $expected
     */
    public function testGetImportUrl($asset, $debug, $use_controller, $expected)
    {
        $this->configuration->setDebug($debug);
        $this->configuration->setUseController($use_controller);
        $this->assertEquals(
            $expected,
            $this->fixture->getImportUrl($asset)
        );
    }

    /**
     * Data provider
     * 
     * @return array
     */
    public function dataProviderGetImportUrl()
    {
        return [
            [
                "@PolymerBundle:hello-world/hello-world.html.twig", false, false,
                "/bundles/polymer/elements/hello-world/hello-world.html",
            ],
            [
                "@PolymerBundle:hello-world.html.twig", false, false,
                "/bundles/polymer/elements/hello-world/hello-world.html"
            ],
            [
                "@PolymerBundle:hello-world", false, false,
                "/bundles/polymer/elements/hello-world/hello-world"
            ],
            [
                "paper-elements/paper-elements.html", false, false,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [
                "paper-elements.html", false, false,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [
                "paper-elements", false, false,
                "/bower_components/paper-elements/paper-elements"
            ],
            [
                "/components/paper-elements/paper-elements.html", false, false,
                "/components/paper-elements/paper-elements.html"
            ],
            [
                "/components/paper-elements.html", false, false,
                "/components/paper-elements.html"
            ],
            [
                "/paper-elements.html", false, false,
                "/paper-elements.html"
            ],
            [
                "/paper-elements", false, false,
                "/paper-elements"
            ],
            
            [
                "@PolymerBundle:hello-world/hello-world.html.twig", true, false,
                "/bundles/polymer/elements/hello-world/hello-world.html",
            ],
            [
                "@PolymerBundle:hello-world/hello-world.html.twig", false, true,
                "/bundles/polymer/elements/hello-world/hello-world.html",
            ],
            
            [
                "@PolymerBundle:hello-world/hello-world.html.twig", true, true,
                PolymerConfiguration::ROUTE_IMPORT . "?bundle=PolymerBundle&element=" . urlencode("hello-world/hello-world.html.twig")
            ],
            [
                "@PolymerBundle:hello-world.html.twig", true, true,
                PolymerConfiguration::ROUTE_IMPORT . "?bundle=PolymerBundle&element=" . urlencode("hello-world/hello-world.html.twig")
            ],
            [
                "@PolymerBundle:hello-world.html", true, true,
                PolymerConfiguration::ROUTE_IMPORT . "?bundle=PolymerBundle&element=" . urlencode("hello-world/hello-world.html")
            ],
            [
                "paper-elements/paper-elements.html", true, true,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [
                "paper-elements.html", true, true,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [
                "paper-elements", true, true,
                "/bower_components/paper-elements/paper-elements"
            ],
            [
                "/components/paper-elements/paper-elements.html", true, true,
                "/components/paper-elements/paper-elements.html"
            ]
        ];
    }
}