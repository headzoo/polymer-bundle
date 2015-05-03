<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Filters;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareInterface;

/**
 * Interface for classes which provides Twig filters.
 */
interface FilterProviderInterface
    extends PolymerConfigurationAwareInterface
{
    /**
     * Returns a list of extension filters
     *
     * @return callable[]
     */
    public function getFilters();
}