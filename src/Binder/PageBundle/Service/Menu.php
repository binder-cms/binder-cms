<?php

namespace Binder\PageBundle\Service;

use Binder\PageBundle\Model\MenuItem;

/**
 * Interface for classes that generate menus.
 */
interface Menu
{
    /**
     * The top-level items in the menu.
     *
     * @return MenuItem[]
     */
    public function getItems();
}
