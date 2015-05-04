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
    public function isRelativeOnDebug()
    {
        return $this->get(self::KEY_RELATIVE_ON_DEBUG);
    }

    /**
     * {@inheritdoc}
     */
    public function setRelativeOnDebug($relative_on_debug)
    {
        return $this->set(self::KEY_RELATIVE_ON_DEBUG, $relative_on_debug);
    }
    
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
            self::KEY_RELATIVE_ON_DEBUG => self::DEFAULT_RELATIVE_ON_DEBUG,
            self::KEY_ELEMENTS          => self::DEFAULT_ELEMENTS,
            self::KEY_COMPONENTS        => self::DEFAULT_COMPONENTS
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function testValue($key, $value)
    {
        $msg = 'Configuration value "%s" is expected to be a %s.';
        
        switch($key) {
            case self::KEY_RELATIVE_ON_DEBUG:
                if (!is_bool($value)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg,
                        $key,
                        "boolean"
                    ));
                }
                break;
            default:
                if (!is_string($value)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg,
                        $key,
                        "string"
                    ));
                }
                break;
        }

        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected static function cast($key, &$value)
    {
        switch($key) {
            case self::KEY_RELATIVE_ON_DEBUG:
                if (is_int($value)) {
                    $value = (bool)$value;
                }
                break;
        }
    }
}