<?php
namespace Headzoo\Bundle\PolymerBundle\Tests\Config;

use Headzoo\Bundle\PolymerBundle\Config\TwigConfiguration;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Bundle\PolymerBundle\Config\TwigConfiguration
 */
class TwigConfigurationTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var TwigConfiguration
     */
    protected $fixture;

    /**
     * Called before each test is run
     */
    public function setUp()
    {
        $this->fixture = new TwigConfiguration();
    }

    /**
     * @covers ::prefix
     */
    public function testPrefix()
    {
        $expected = TwigConfiguration::DEFAULT_PREFIX . "func";
        $this->assertEquals(
            $expected,
            $this->fixture->prefix("func")
        );
    }

    /**
     * @covers ::getTemplate
     */
    public function testGetTemplate()
    {
        $this->assertEquals(
            TwigConfiguration::DEFAULT_TEMPLATE_IMPORT,
            $this->fixture->getTemplate(TwigConfiguration::TEMPLATE_IMPORT)
        );
    }

    /**
     * @covers ::getTemplate
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidArgumentException
     */
    public function testGetTemplateInvalid()
    {
        $this->fixture->getTemplate("testing");
    }

    /**
     * @covers ::testValue
     */
    public function testTestValue()
    {
        $this->assertTrue(
            $this->fixture->testValue(TwigConfiguration::KEY_PREFIX, "polymer")
        );
    }
}