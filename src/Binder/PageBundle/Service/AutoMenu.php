<?php

namespace Binder\PageBundle\Service;


use Binder\PageBundle\Model\MenuItem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Automatically scans the application's pages and builds a menu.
 */
class AutoMenu implements Menu
{
    private $pagesDir;

    public function __construct($pagesDir)
    {
        $this->pagesDir = $pagesDir;
    }

    public function getItems()
    {
        $finder = new Finder();
        $finder->files()->in($this->pagesDir)->depth(0);
        $items = [];
        foreach ($finder as $file) {
            /** @var $file SplFileInfo */
            $url = $this->templateToPath($file->getRelativePathname());
            $name = $file->getBasename();
            $items[] = new MenuItem($name, $url);
        }
        return $items;
    }

    /**
     * @param string $template
     * @return string
     */
    public function templateToPath($template)
    {
        $d = basename($this->pagesDir);
        $path = str_replace(":$d:", '', $template);
        $path = str_replace('.twig', '', $path);
        return $path;
    }

}
