<?php
namespace Headzoo\Bundle\PolymerBundle\Util\Exception;

use Headzoo\Bundle\PolymerBundle\Exception\PolymerException;

/**
 * Thrown when trying to resolve a path that does not exist.
 */
class PathNotFoundException
    extends PolymerException {}