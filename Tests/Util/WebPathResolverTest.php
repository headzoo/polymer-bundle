<?php
namespace Headzoo\Bundle\PolymerBundle\Tests\Util;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Util\WebPathResolver;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @coversDefaultClass \Headzoo\Bundle\PolymerBundle\Util\WebPathResolver
 */
class WebPathResolverTest
    extends KernelTestCase
{
    /**
     * @var WebPathResolver
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
        $this->fixture = new WebPathResolver(static::$kernel);
        $this->fixture->setConfiguration(new PolymerConfiguration());
    }

    /**
     * @covers ::getPrefix
     */
    public function testGetPrefix()
    {
        $this->assertEquals(
            "/bundles/polymer",
            $this->fixture->getPrefix("PolymerBundle")
        );
    }

    /**
     * @covers ::getPath
     */
    public function testGetPath()
    {
        $elements_path = (new PolymerConfiguration())->getPaths()->getElements();
        $this->assertEquals(
            "/bundles/polymer/{$elements_path}/hello-world/hello-world.html",
            $this->fixture->getPath("PolymerBundle", "hello-world/hello-world.html")
        );
    }
}