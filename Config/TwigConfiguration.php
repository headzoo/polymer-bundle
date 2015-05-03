<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Twig configuration.
 */
class TwigConfiguration
    extends ArrayConfiguration
    implements TwigConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return $this->get(self::KEY_TAG);
    }

    /**
     * {@inheritdoc}
     */
    public function setTag($tag)
    {
        return $this->set(self::KEY_TAG, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        return $this->get(self::KEY_TEMPLATES);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate($name)
    {
        if (!isset($this->values[self::KEY_TEMPLATES][$name])) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Template with name "%s" does not exist.',
                $name
            ));
        }
        
        return $this->values[self::KEY_TEMPLATES][$name];
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplates(array $templates)
    {
        return $this->set(self::KEY_TEMPLATES, $templates);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            self::KEY_TAG       => self::DEFAULT_TAG,
            self::KEY_TEMPLATES => [
                self::TEMPLATE_ELEMENT => self::DEFAULT_TEMPLATE_ELEMENT,
                self::TEMPLATE_IMPORT  => self::DEFAULT_TEMPLATE_IMPORT
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function testValue($key, $value)
    {
        $msg = 'Configuration value "%s" is expected to be a %s.';
        
        switch($key) {
            case self::KEY_TAG:
                if (!is_string($value)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg, $key, "string"
                    ));
                }
                break;
            case self::KEY_TEMPLATES:
                if (!is_array($value)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg, $key, "array"
                    ));
                }
                break;
        }
        
        return true;
    }
}