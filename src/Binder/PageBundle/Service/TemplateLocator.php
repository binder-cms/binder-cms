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
     * @var string
     */
    private $pageDir;

    public function __construct(EngineInterface $templating, $pagedir)
    {
        $this->templating = $templating;
        $this->pageDir = trim($pagedir, '/');
    }

    /**
     * @param string $path
     * @return string|null
     */
    public function pathToTemplate($path)
    {
        $path = trim($path, '/') ?: 'index.html';
        // The templating system doesn't like dashes in template filenames
        // for some reason.
        $path = str_replace('-', '_', $path);

        $d = $this->pageDir;
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
