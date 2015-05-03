<?php
namespace Headzoo\Bundle\PolymerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Used to import element paths when debugging.
 */
class ImportController
    extends Controller
{
    public function elementAction(Request $request)
    {
        $element = $request->query->get("element");
        if (!$element) {
            return new Response('Element Not Found', 404);
        }
        
        try {
            $parts = explode(":", $element, 2);
            $configuration = $this->get("polymer.configuration");
            $elements_path = $configuration->getPaths()->getElements();
            $resource_path = "{$parts[0]}/Resources/public/{$elements_path}/{$parts[1]}";
            $template_path = $this->get("kernel")->locateResource($resource_path);
            
            return $this->render($template_path);
        } catch (\Exception $e) {
            return new Response('Element Not Found', 404);
        }
    }
}