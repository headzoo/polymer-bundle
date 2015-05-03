<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * The Polymer configuration.
 */
class PolymerConfiguration
    extends ArrayConfiguration
    implements PolymerConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAutoVerbatim()
    {
        return $this->get(self::KEY_AUTO_VERBATIM);
    }

    /**
     * {@inheritdoc}
     */
    public function setAutoVerbatim($auto_verbatim)
    {
        return $this->set(self::KEY_AUTO_VERBATIM, $auto_verbatim);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getImports()
    {
        return $this->get(self::KEY_IMPORTS);
    }

    /**
     * {@inheritdoc}
     */
    public function setImports(array $imports)
    {
        return $this->set(self::KEY_IMPORTS, $imports);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTwig()
    {
        return $this->get(self::KEY_TWIG);
    }

    /**
     * {@inheritdoc}
     */
    public function setTwig(TwigConfigurationInterface $twig)
    {
        return $this->set(self::KEY_TWIG, $twig);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaths()
    {
        return $this->get(self::KEY_PATHS);
    }

    /**
     * {@inheritdoc}
     */
    public function setPaths(PathsConfigurationInterface $paths)
    {
        return $this->set(self::KEY_PATHS, $paths);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            self::KEY_AUTO_VERBATIM => true,
            self::KEY_IMPORTS       => [],
            self::KEY_PATHS         => new PathsConfiguration(),
            self::KEY_TWIG          => new TwigConfiguration()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function testValue($key, $value)
    {
        $msg = 'Configuration value "%s" is expected to be an instance of %s.';
        
        switch($key) {
            case self::KEY_AUTO_VERBATIM:
                if (!is_bool($value)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg, self::KEY_AUTO_VERBATIM, "boolean"
                    ));
                }
                break;
            case self::KEY_IMPORTS:
                if (!is_array($value)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg, self::KEY_IMPORTS, "array"
                    ));
                }
                break;
            case self::KEY_TWIG:
                if (!($value instanceof TwigConfigurationInterface)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg, self::KEY_TWIG, TwigConfigurationInterface::class
                    ));
                }
                break;
            case self::KEY_PATHS:
                if (!($value instanceof PathsConfigurationInterface)) {
                    throw new Exception\InvalidValueException(sprintf(
                        $msg, self::KEY_PATHS, PathsConfigurationInterface::class
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
            case self::KEY_AUTO_VERBATIM:
                if (is_int($value)) {
                    $value = (bool)$value;
                }
                break;
            default:
                if (is_array($value)) {
                    switch($key) {
                        case self::KEY_TWIG:
                            $value = new TwigConfiguration($value);
                            break;
                        case self::KEY_PATHS:
                            $value = new PathsConfiguration($value);
                            break;
                    }
                }
                break;
        }
    }
}