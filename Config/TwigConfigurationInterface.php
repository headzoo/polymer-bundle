<?php
namespace Headzoo\Bundle\PolymerBundle\Config;

/**
 * Interface for Polymer Twig configuration.
 */
interface TwigConfigurationInterface
    extends ArrayConfigurationInterface
{
    const DEFAULT_PREFIX = "polymer_";
    const DEFAULT_TAG = "polymer";
    const DEFAULT_TEMPLATE_IMPORT = "PolymerBundle:polymer:import.html.twig";
    const DEFAULT_TEMPLATE_ELEMENT = "PolymerBundle:polymer:element.html.twig";
    const KEY_PREFIX = "prefix";
    const KEY_TAG = "tag";
    const KEY_TEMPLATES = "templates";
    const TEMPLATE_IMPORT = "import";
    const TEMPLATE_ELEMENT = "element";

    /**
     * Gets the string to use for polymer tags
     * 
     * @return string
     */
    public function getTag();

    /**
     * Sets the value to use for polymer tags
     * 
     * @param string $tag
     *
     * @return $this
     */
    public function setTag($tag);

    /**
     * Gets the string prefix for all Twig functions, filters, and tags
     *
     * @return string
     */
    public function getPrefix();

    /**
     * Sets the string prefix used on all Twig functions, filters, and tags
     *
     * @param string $prefix The prefix
     *
     * @return $this
     */
    public function setPrefix($prefix);

    /**
     * Prepends the prefix to the given string
     *
     * @param string $str The string to prefix
     *
     * @return string
     */
    public function prefix($str);

    /**
     * Gets an array of Twig templates
     *
     * @return array
     */
    public function getTemplates();

    /**
     * Gets the template with the given name
     *
     * @param string $name The template name
     *
     * @return string
     *
     * @throws Exception\InvalidArgumentException
     */
    public function getTemplate($name);

    /**
     * Sets the array of Twig templates
     *
     * @param array $templates The templates
     *
     * @return $this
     */
    public function setTemplates(array $templates);
}