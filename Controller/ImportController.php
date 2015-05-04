<?php
namespace Headzoo\Bundle\PolymerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Used to import element paths when debugging.
 */
class ImportController
    extends Controller
{
    public function elementAction(Request $request)
    {
        if (!$this->get("kernel")->isDebug()) {
            throw $this->createNotFoundException();
        }
        
        $bundle  = $request->query->get("bundle");
        $element = $request->query->get("element");
        if (!$bundle || !$element) {
            throw $this->createNotFoundException();
        }
        
        $configuration = $this->get("polymer.configuration");
        $elements_path = $configuration->getPaths()->getElements();
        $resource_path = "@{$bundle}/Resources/public/{$elements_path}/{$element}";

        return $this->render($this->get("kernel")->locateResource($resource_path));
    }
}