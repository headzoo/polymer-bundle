<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Paths configuration.
 */
class PathsConfiguration
    extends ArrayConfiguration
    implements PathsConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getElements()
    {
        return $this->get(self::KEY_ELEMENTS);
    }

    /**
     * {@inheritdoc}
     */
    public function setElements($elements)
    {
        return $this->set(self::KEY_ELEMENTS, $elements);
    }

    /**
     * {@inheritdoc}
     */
    public function getComponents()
    {
        return $this->get(self::KEY_COMPONENTS);
    }

    /**
     * {@inheritdoc}
     */
    public function setComponents($components)
    {
        return $this->set(self::KEY_COMPONENTS, $components);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            self::KEY_ELEMENTS   => self::DEFAULT_ELEMENTS,
            self::KEY_COMPONENTS => self::DEFAULT_COMPONENTS
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function testValue($key, $value)
    {
        if (!is_string($value)) {
            throw new Exception\InvalidValueException(sprintf(
                'Configuration value "%s" is expected to be a string.',
                $key
            ));
        }
        
        return true;
    }
}