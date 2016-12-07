<?php

namespace Binder\PageBundle\Service;

use Binder\PageBundle\Model\MenuItem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Automatically scans the application's pages and builds a menu.
 */
class AutoMenu implements Menu
{
    /**
     * @var PageDirectory
     */
    private $pageDir;

    /**
     * @var UrlResolver
     */
    private $resolver;

    public function __construct(PageDirectory $pageDir)
    {
        $this->pageDir = $pageDir;
        $this->resolver = new UrlResolver($pageDir);
    }

    /**
     * You can override the default UrlResolver when needed; eg, for testing.
     */
    public function setResolver(UrlResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function getItems()
    {
        $files = $this->pageDir->scanFiles();
        $items = [];
        foreach ($files as $file) {
            /** @var $file SplFileInfo */
            $url = $this->resolver->templateToPath($file->getRelativePathname());
            $label = $this->generateLinkLabel($file);
            $items[] = new MenuItem($label, $url);
        }
        return $items;
    }

    private function generateLinkLabel(SplFileInfo $file)
    {
        $title = $file->getBasename();
        $title = str_ireplace('.twig', '', $title);
        $title = str_ireplace('.html', '', $title);
        $title = str_ireplace('_', ' ', $title);
        return ucfirst($title);
    }
}
