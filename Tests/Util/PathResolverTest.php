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
     * @covers ::findCommonPath
     */
    public function testFindCommonPath()
    {
        $this->assertEquals(
            "/var/www",
            $this->fixture->findCommonPath(["/var/www/example1", "/var/www/example2"])
        );
    }

    /**
     * @covers ::getBundleWebPrefix
     */
    public function testGetBundleWebPrefix()
    {
        $this->assertEquals(
            "/bundles/polymer",
            $this->fixture->getBundleWebPrefix("PolymerBundle")
        );
    }

    /**
     * @covers ::getBundleWebPath
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
     * @covers ::getBundleRelativeWebPath
     */
    public function testGetBundleRelativeWebPath()
    {
        $elements_path = (new PolymerConfiguration())->getPaths()->getElements();
        $this->assertEquals(
            "/../src/Headzoo/Bundle/PolymerBundle/Resources/public/{$elements_path}/hello-world/hello-world.html",
            $this->fixture->getBundleRelativeWebPath("PolymerBundle", "hello-world/hello-world.html")
        );
    }

    /**
     * @covers ::getImportUrl
     * @dataProvider dataProviderGetImportUrl
     * 
     * @param string $asset
     * @param bool   $debug
     * @param bool   $relative_on_debug
     * @param string $expected
     */
    public function testGetImportUrl($asset, $debug, $relative_on_debug, $expected)
    {
        $this->configuration->setDebug($debug);
        $this->configuration->getPaths()->setRelativeOnDebug($relative_on_debug);
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
            [ // 0
                "@PolymerBundle:hello-world/hello-world.html.twig", false, false,
                "/bundles/polymer/elements/hello-world/hello-world.html",
            ],
            [ // 1
                "@PolymerBundle:hello-world.html.twig", false, false,
                "/bundles/polymer/elements/hello-world/hello-world.html"
            ],
            [ // 2
                "@PolymerBundle:hello-world", false, false,
                "/bundles/polymer/elements/hello-world/hello-world"
            ],
            [ // 3
                "paper-elements/paper-elements.html", false, false,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [ // 4
                "paper-elements.html", false, false,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [ // 5
                "paper-elements", false, false,
                "/bower_components/paper-elements/paper-elements"
            ],
            [ // 6
                "/components/paper-elements/paper-elements.html", false, false,
                "/components/paper-elements/paper-elements.html"
            ],
            [ // 7
                "/components/paper-elements.html", false, false,
                "/components/paper-elements.html"
            ],
            [ // 8
                "/paper-elements.html", false, false,
                "/paper-elements.html"
            ],
            [ // 9
                "/paper-elements", false, false,
                "/paper-elements"
            ],
            [ // 10
                "@PolymerBundle:hello-world/hello-world.html.twig", true, true,
                "/../src/Headzoo/Bundle/PolymerBundle/Resources/public/elements/hello-world/hello-world.html.twig",
            ],
            [ // 11
                "@PolymerBundle:hello-world/hello-world.html.twig", false, true,
                "/bundles/polymer/elements/hello-world/hello-world.html",
            ],
            [ // 12
                "@PolymerBundle:hello-world/hello-world.html.twig", true, false,
                PolymerConfiguration::ROUTE_IMPORT . "?bundle=PolymerBundle&element=" . urlencode("hello-world/hello-world.html.twig")
            ],
            [ // 13
                "@PolymerBundle:hello-world.html.twig", true, false,
                PolymerConfiguration::ROUTE_IMPORT . "?bundle=PolymerBundle&element=" . urlencode("hello-world/hello-world.html.twig")
            ],
            [ // 14
                "@PolymerBundle:hello-world.html", true, false,
                PolymerConfiguration::ROUTE_IMPORT . "?bundle=PolymerBundle&element=" . urlencode("hello-world/hello-world.html")
            ],
            [ // 15
                "paper-elements/paper-elements.html", true, true,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [ // 16
                "paper-elements.html", true, true,
                "/bower_components/paper-elements/paper-elements.html"
            ],
            [ // 17
                "paper-elements", true, true,
                "/bower_components/paper-elements/paper-elements"
            ],
            [ // 18
                "/components/paper-elements/paper-elements.html", true, true,
                "/components/paper-elements/paper-elements.html"
            ]
        ];
    }
}