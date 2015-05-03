<?php
namespace Headzoo\Bundle\PolymerBundle\Tests\Config;

use Headzoo\Bundle\PolymerBundle\Config\ArrayConfiguration;
use Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidValueException;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Bundle\PolymerBundle\Config\ArrayConfiguration
 */
class ArrayConfigurationTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayConfigurationFixture
     */
    protected $fixture;

    /**
     * Called before each test is run
     */
    public function setUp()
    {
        $this->fixture = new ArrayConfigurationFixture(["path" => "/testing"]);
    }

    /**
     * @covers ::set
     */
    public function testSet()
    {
        $this->assertSame(
            $this->fixture,
            $this->fixture->set("prefix", "polymer_test")
        );
    }

    /**
     * @covers ::set
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidKeyException
     */
    public function testSetInvalidKey()
    {
        $this->fixture->set("testing", []);
    }

    /**
     * @covers ::set
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidValueException
     */
    public function testSetInvalidValue()
    {
        $this->fixture->set("template", []);
    }

    /**
     * @covers ::get
     * @depends testSet
     */
    public function testGet()
    {
        $this->fixture->set("prefix", "polymer_test");
        $this->assertEquals(
            "polymer_test",
            $this->fixture->get("prefix")
        );
    }

    /**
     * @covers ::get
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidKeyException
     */
    public function testGetInvalidKey()
    {
        $this->fixture->get("testing");
    }

    /**
     * @covers ::fromArray
     * @depends testGet
     */
    public function testFromArray()
    {
        $values = [
            "prefix" => "polymer_",
            "path"   => "/testing"
        ];
        $this->fixture->fromArray($values);
        
        $this->assertEquals(
            "polymer_",
            $this->fixture->get("prefix")
        );
        $this->assertEquals(
            "/testing",
            $this->fixture->get("path")
        );
        $this->assertEquals(
            "PolymerBundle:polymer:import_element.html.twig",
            $this->fixture->get("template")
        );
        
    }

    /**
     * @covers ::fromArray
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\RequiredValueException
     */
    public function testFromArrayRequiredValue()
    {
        $values = [
            "prefix" => "polymer_"
        ];
        $this->fixture->fromArray($values);
    }

    /**
     * @covers ::fromArray
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidValueException
     */
    public function testFromArrayInvalidValue()
    {
        $values = [
            "prefix"   => "polymer_",
            "path"     => "/testing",
            "template" => []
        ];
        $this->fixture->fromArray($values);
    }

    /**
     * @covers ::toArray
     * @depends testFromArray
     */
    public function testToArray()
    {
        $values = [
            "prefix" => "polymer_",
            "path"   => "/testing"
        ];
        $this->fixture->fromArray($values);
        $expected = [
            "prefix"   => "polymer_",
            "template" => "PolymerBundle:polymer:import_element.html.twig",
            "path"     => "/testing"
        ];
        
        $this->assertEquals(
            $expected,
            $this->fixture->toArray()
        );
    }

    /**
     * @covers ::isValidKey
     */
    public function testIsValidKey()
    {
        $this->assertTrue(
            $this->fixture->isValidKey("prefix")
        );
        $this->assertTrue(
            $this->fixture->isValidKey("template")
        );
        $this->assertTrue(
            $this->fixture->isValidKey("path")
        );
        $this->assertFalse(
            $this->fixture->isValidKey("testing")
        );
    }

    /**
     * @covers ::getDefault
     */
    public function testGetDefault()
    {
        $this->assertEquals(
            "polymer_",
            $this->fixture->getDefault("prefix")
        );
        $this->assertEquals(
            "PolymerBundle:polymer:import_element.html.twig",
            $this->fixture->getDefault("template")
        );
        $this->assertNull(
            $this->fixture->getDefault("path")
        );
    }

    /**
     * @covers ::getDefault
     * @expectedException \Headzoo\Bundle\PolymerBundle\Config\Exception\InvalidKeyException
     */
    public function testGetDefaultInvalidKey()
    {
        $this->fixture->getDefault("testing");
    }
}

class ArrayConfigurationFixture
    extends ArrayConfiguration
{
    protected static $defaults = [
        "prefix"   => "polymer_",
        "template" => "PolymerBundle:polymer:import_element.html.twig"
    ];

    /**
     * {@inheritdoc}
     */
    public static function testValue($key, $value)
    {
        if ($key === "template" && !is_string($value)) {
            throw new InvalidValueException("Invalid value.");
        }
        
        return true;
    }
    
    public static function getDefaults()
    {
        return self::$defaults;
    }
    
    public static function getKeys()
    {
        return [
            "prefix",
            "template",
            "path"
        ];
    }
}