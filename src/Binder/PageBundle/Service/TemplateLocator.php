<?php

namespace Binder\PageBundle\Service;

use Symfony\Component\Templating\EngineInterface;

/**
 * Maps URL paths to Twig templates and vice-versa.
 */
class TemplateLocator
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * The directory where user pages are kept.
     *
     * @var PageDirectory
     */
    private $pageDir;

    public function __construct(EngineInterface $templating, PageDirectory $pageDir)
    {
        $this->templating = $templating;
        $this->pageDir = $pageDir;
    }

    /**
     * Takes a URL path and returns the template that should be used to
     * render that page.
     *
     * @param string $path The URL path
     * @return string|null The template name; null if there is no matching
     *                     template
     */
    public function pathToTemplate($path)
    {
        $path = trim($path, '/') ?: 'index.html';
        // The templating system doesn't like dashes in template filenames
        // for some reason.
        $path = str_replace('-', '_', $path);

        $d = $this->pageDir->getBasename();
        $try = [
            ":$d:$path.twig",
            ":$d:$path/index.html.twig",
            ":$d:$path",
        ];
        foreach ($try as $template) {
            if ($this->templating->exists($template)) {
                return $template;
            }
        }
        return null;
    }
}
