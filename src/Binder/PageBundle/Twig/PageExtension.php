<?php

namespace Binder\PageBundle\Twig;


use Binder\PageBundle\Model\MenuItem;
use Binder\PageBundle\Service\AutoMenu;
use Binder\PageBundle\Service\Menu;
use Twig_Extension;

class PageExtension extends Twig_Extension
{
    /** @var AutoMenu */
    private $autoMenu;

    public function __construct(AutoMenu $autoMenu)
    {
        $this->autoMenu = $autoMenu;
    }

    public function getName()
    {
        return 'binder_page';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('auto_menu', [$this, 'renderAutoMenu'], [
                'is_safe' => ['html'],
            ])
        ];
    }

    public function renderAutoMenu()
    {
        return $this->renderMenu($this->autoMenu);
    }

    private function renderMenu(Menu $menu)
    {
        return $this->renderItems($menu->getItems());
    }

    /**
     * @param MenuItem[] $items
     * @return string
     */
    private function renderItems(array $items)
    {
        if (count($items) == 0) {
            return '';
        }
        $html = '<ul class="menu">';
        foreach ($items as $item) {
            $html .= $this->renderItem($item);
        }
        $html .= '</ul>';
        return $html;
    }

    private function renderItem(MenuItem $item)
    {
        $html = htmlentities($item->getLabel());
        if ($item->hasUrl()) {
            $html = sprintf('<a href="%s">%s</a>',
                $item->getUrl(),
                $html);
        }
        $html .= $this->renderItems($item->getChildren());
        return "<li>$html</li>";
    }

}
