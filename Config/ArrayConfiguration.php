<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Implements the ArrayConfigurationInterface interface.
 */
abstract class ArrayConfiguration
    implements ArrayConfigurationInterface
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * Constructor
     * 
     * @param array $values The configuration values
     */
    public function __construct(array $values = [])
    {
        $this->fromArray($values);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        if (!isset($this->values[$key])) {
            if (!static::isValidKey($key)) {
                throw new Exception\InvalidKeyException(sprintf(
                    'Configuration value for key "%s" does not exist.',
                    $key
                ));
            }
            
            return null;
        }
        
        return $this->values[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        if (!static::isValidKey($key)) {
            throw new Exception\InvalidKeyException(sprintf(
                'Configuration value for key "%s" does not exist.',
                $key
            ));
        }
        
        $this->cast($key, $value);
        static::testValue($key, $value);
        $this->values[$key] = $value;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $values)
    {
        foreach(static::getKeys() as $key) {
            if (isset($values[$key])) {
                $this->set($key, $values[$key]);
            } else if (null !== ($default = static::getDefault($key))) {
                $this->set($key, $default);
            } else {
                throw new Exception\RequiredValueException(sprintf(
                    'Required configuration value for key "%s" not found.',
                    $key
                ));
            }
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefault($key)
    {
        if (!static::isValidKey($key)) {
            throw new Exception\InvalidKeyException(sprintf(
                'Configuration value for key "%s" does not exist.',
                $key
            ));
        }
        
        $defaults = static::getDefaults();
        if (isset($defaults[$key])) {
            return $defaults[$key];
        }
        
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function getKeys()
    {
        return array_keys(static::getDefaults());
    }

    /**
     * {@inheritdoc}
     */
    public static function isValidKey($key)
    {
        return in_array($key, static::getKeys());
    }

    /**
     * {@inheritdoc}
     */
    public static function testValue($key, $value)
    {
        return true;
    }

    /**
     * Casts the given value from an unsupported type to a supported type
     * 
     * The value remains untouched when it doesn't need to be cast, or can't
     * be cast.
     * 
     * @param string $key   The configuration key
     * @param mixed  $value The value to be cast
     */
    protected static function cast($key, &$value) {}
}