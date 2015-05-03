<?php
namespace Headzoo\Bundle\PolymerBundle\Tests\Config;

use Headzoo\Bundle\PolymerBundle\Config\PathsConfiguration;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Bundle\PolymerBundle\Config\PathsConfiguration
 */
class PathsConfigurationTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var PathsConfiguration
     */
    protected $fixture;

    /**
     * Called before each test is run
     */
    public function setUp()
    {
        $this->fixture = new PathsConfiguration();
    }

    /**
     * @covers ::testValue
     */
    public function testTestValue()
    {
        $this->assertTrue(
            $this->fixture->testValue(PathsConfiguration::KEY_ELEMENTS, "/elements")
        );
    }
}