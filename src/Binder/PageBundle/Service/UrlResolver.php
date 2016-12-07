<?php

namespace Binder\PageBundle\Service;


class UrlResolver
{
    /**
     * The directory where user pages are kept.
     *
     * @var PageDirectory
     */
    private $pageDir;

    /**
     * @param string $pageDir
     */
    public function __construct(PageDirectory $pageDir)
    {
        $this->pageDir = $pageDir;
    }

    /**
     * Takes a template name or path and returns the URL path of
     * the page that it renders.
     *
     * @param string $template The template name
     * @return string The URL path
     */
    public function templateToPath($template)
    {
        $d = $this->pageDir->getBasename();
        $path = str_replace(":$d:", '', $template);
        $path = str_replace('.twig', '', $path);
        return $path;
    }

}
