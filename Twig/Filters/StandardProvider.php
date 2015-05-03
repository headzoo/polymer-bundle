<?php
namespace Headzoo\Bundle\PolymerBundle\Twig\Filters;

use Headzoo\Bundle\PolymerBundle\Config\PolymerConfigurationAwareTrait;

/**
 * Polymer standard Twig filters.
 */
class StandardProvider
    implements FilterProviderInterface
{
    use PolymerConfigurationAwareTrait;
    
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [];
    }
}