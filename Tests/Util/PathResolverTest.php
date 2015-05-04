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
        $this->fixture = new PathResolver(new PolymerConfiguration(), static::$kernel);
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
}