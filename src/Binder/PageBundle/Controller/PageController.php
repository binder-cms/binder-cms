<?php

namespace Binder\PageBundle\Controller;


use Binder\PageBundle\Service\TemplateLocator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        if ($template) {
            return $this->render($template);
        }
        throw new NotFoundHttpException();
    }

    private function convertPathToTemplate($path)
    {
        /** @var $locator TemplateLocator */
        $locator = $this->get('binder_page.template_locator');
        return $locator->pathToTemplate($path);
    }
}
