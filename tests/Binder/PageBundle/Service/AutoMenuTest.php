<?php

namespace Tests\Binder\PageBundle\Service;


use Binder\PageBundle\Service\AutoMenu;
use Tests\Binder\FunctionalTestCase;

class AutoMenuTest extends FunctionalTestCase
{
    public function test()
    {
        static::bootKernel();
        $container = static::$kernel->getContainer();
        $menu = new AutoMenu($container->getParameter('binder_page.path'));
        $this->assertCount(2, $menu->getItems());
    }
}
