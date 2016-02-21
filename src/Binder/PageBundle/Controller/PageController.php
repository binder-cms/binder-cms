<?php

namespace Binder\PageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This is the main controller for rendering website pages.
 */
class PageController extends Controller
{
    /**
     * Renders the page whose URL path is given.
     */
    public function showAction($path)
    {
        $template = $this->convertPathToTemplate($path);
        if ($this->templateExists($template)) {
            return $this->render($template);
        }
        throw new NotFoundHttpException();
    }

    private function convertPathToTemplate($path)
    {
        $path = trim($path, '/');
        // A path of "/" is rendered by index.html.twig.
        if ('' === $path) {
            $path = 'index';
        }
        // The templating system doesn't like dashes in template filenames
        // for some reason.
        $path = str_replace('-', '_', $path);
        return ":pages:$path.html.twig";
    }

    private function templateExists($template)
    {
        /** @var $engine EngineInterface */
        $engine = $this->get('templating');
        return $engine->exists($template);
    }
}
