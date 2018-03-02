<?php

namespace Binder\PageBundle\Controller;


use Binder\PageBundle\Service\TemplateLocator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Templating\EngineInterface;

/**
 * This is the main controller for rendering website pages.
 */
class PageController
{
    /** @var TemplateLocator */
    private $locator;

    /** @var EngineInterface */
    private $templating;

    public function __construct(TemplateLocator $locator, EngineInterface $templating)
    {
        $this->locator = $locator;
        $this->templating = $templating;
    }

    /**
     * Renders the page whose URL path is given.
     */
    public function showAction(string $path)
    {
        if ($this->locator->templateExists($path)) {
            $template = $this->locator->pathToTemplate($path);
            return $this->render($template);
        }
        throw new NotFoundHttpException();
    }

    private function render(string $template, array $params = []): Response
    {
        $content = $this->templating->render($template, $params);
        return new Response($content);
    }
}
