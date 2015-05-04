<?php
namespace Headzoo\Bundle\PolymerBundle\Tests\Config;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\TwigConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\TwigConfigurationInterface;
use Headzoo\Bundle\PolymerBundle\Config\PathsConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\PathsConfigurationInterface;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Bundle\PolymerBundle\Config\PolymerConfiguration
 */
class PolymerConfigurationTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var PolymerConfiguration
     */
    protected $fixture;

    /**
     * Called before each test is run
     */
    public function setUp()
    {
        $this->fixture = new PolymerConfiguration();
    }

    /**
     * @covers ::getTwig
     */
    public function testGetTwig()
    {
       $this->assertInstanceOf(
           TwigConfigurationInterface::class,
           $this->fixture->getTwig()
       );
    }

    /**
     * @covers ::setTwig
     */
    public function testSetTwig()
    {
        $this->assertSame(
            $this->fixture,
            $this->fixture->setTwig(new TwigConfiguration())
        );
    }

    /**
     * @covers ::set
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidValueException
     */
    public function testSetTwigInvalidValue()
    {
        $this->fixture->set(PolymerConfiguration::KEY_TWIG, $this);
    }

    /**
     * @covers ::getPaths
     */
    public function testGetPaths()
    {
        $this->assertInstanceOf(
            PathsConfigurationInterface::class,
            $this->fixture->getPaths()
        );
    }

    /**
     * @covers ::setPaths
     */
    public function testSetPaths()
    {
        $this->assertSame(
            $this->fixture,
            $this->fixture->setPaths(new PathsConfiguration())
        );
    }

    /**
     * @covers ::set
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidValueException
     */
    public function testSetPathsInvalidValue()
    {
        $this->fixture->set(PolymerConfiguration::KEY_PATHS, $this);
    }

    /**
     * @covers ::fromArray
     */
    public function testFromArray()
    {
        $this->assertSame(
            $this->fixture,
            $this->fixture->fromArray($this->getTestArray())
        );
    }

    /**
     * @covers ::toArray
     * @depends testFromArray
     */
    public function testToArray()
    {
        $values = $this->getTestArray();
        $this->fixture->fromArray($values);
        
        $values[PolymerConfiguration::KEY_TWIG] = new TwigConfiguration(
            $values[PolymerConfiguration::KEY_TWIG]
        );
        $values[PolymerConfiguration::KEY_PATHS] = new PathsConfiguration(
            $values[PolymerConfiguration::KEY_PATHS]
        );
        
        $this->assertEquals(
            $values,
            $this->fixture->toArray()
        );
    }
    
    /**
     * @covers ::testValue
     */
    public function testTestValue()
    {
        $this->assertTrue(
            $this->fixture->testValue(PolymerConfiguration::KEY_TWIG, new TwigConfiguration())
        );
    }

    /**
     * @return array
     */
    protected function getTestArray()
    {
        return [
            PolymerConfiguration::KEY_AUTO_VERBATIM => PolymerConfiguration::DEFAULT_AUTO_VERBATIM,
            PolymerConfiguration::KEY_DEBUG => PolymerConfiguration::DEFAULT_DEBUG,
            PolymerConfiguration::KEY_AUTO_IMPORTS => [],
            PolymerConfiguration::KEY_TWIG => [
                TwigConfiguration::KEY_TAG => TwigConfiguration::DEFAULT_TAG,
                TwigConfiguration::KEY_TEMPLATES => [
                    TwigConfiguration::TEMPLATE_IMPORT => TwigConfiguration::DEFAULT_TEMPLATE_IMPORT
                ]
            ],
            PolymerConfiguration::KEY_PATHS => [
                PathsConfiguration::KEY_ELEMENTS   => PathsConfiguration::DEFAULT_ELEMENTS,
                PathsConfiguration::KEY_COMPONENTS => PathsConfiguration::DEFAULT_COMPONENTS
            ]
        ];
    }
}