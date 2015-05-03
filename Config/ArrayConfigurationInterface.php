<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Interface for config classes which may be created with an array, and
 * which can return the same array.
 */
interface ArrayConfigurationInterface
{
    /**
     * Gets the configuration value with the given key
     *
     * Returns null when the value has not been set.
     * 
     * @param string $key The configuration key
     *
     * @return mixed
     *
     * @throws Exception\InvalidKeyException
     */
    public function get($key);

    /**
     * Sets a configuration value using the given key and value
     *
     * @param string $key   The key
     * @param mixed  $value The value
     *
     * @return $this
     *
     * @throws Exception\InvalidKeyException
     * @throws Exception\InvalidValueException
     */
    public function set($key, $value);
    
    /**
     * Configures the class using an array of values
     * 
     * @param array $values The configuration values
     *
     * @return $this
     * 
     * @throws Exception\RequiredValueException
     * @throws Exception\InvalidValueException
     */
    public function fromArray(array $values);

    /**
     * Returns the configuration as an array of values
     * 
     * @return array
     */
    public function toArray();

    /**
     * Returns the default values as an array
     * 
     * @return array
     */
    public static function getDefaults();

    /**
     * Returns the default value for the configuration key
     * 
     * Returns null when a default value does not exist for the given key.
     * 
     * @param string $key The configuration key
     *
     * @return mixed
     * 
     * @throws Exception\InvalidKeyException
     */
    public static function getDefault($key);

    /**
     * Returns an array of each configuration key
     * 
     * @return array
     */
    public static function getKeys();

    /**
     * Returns if the given value matches one of the required keys
     * 
     * @param string $key The config key to test
     *
     * @return bool
     */
    public static function isValidKey($key);

    /**
     * Throws an exception when the value is invalid for the given configuration key
     *
     * This method always returns true.
     *
     * @param string $key   The key
     * @param mixed  $value The value
     *
     * @return bool
     *
     * @throws Exception\InvalidValueException
     */
    public static function testValue($key, $value);
}