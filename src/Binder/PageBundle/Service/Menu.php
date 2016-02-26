<?php


namespace Binder\PageBundle\Service;


use Binder\PageBundle\Model\MenuItem;

interface Menu
{
    /** @return MenuItem[] */
    public function getItems();
}
