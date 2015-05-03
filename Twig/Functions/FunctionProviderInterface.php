<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Functions;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;

/**
 * Interface for classes which provides Twig functions.
 */
interface FunctionProviderInterface
    extends PolymerConfigurationAwareInterface
{
    /**
     * Returns a list of extension functions
     *
     * @return callable[]
     */
    public function getFunctions();
}