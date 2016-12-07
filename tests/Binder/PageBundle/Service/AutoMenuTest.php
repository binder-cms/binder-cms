<?php

namespace Tests\Binder\PageBundle\Service;

use Binder\PageBundle\Service\AutoMenu;
use Tests\Binder\UnitTestCase;

class AutoMenuTest extends UnitTestCase
{
    public function testGetItems_returnsCorrectNumber()
    {
        $stubDir = $this->stubPageDirectory([
            'index.html.twig',
            'contact.html.twig',
            'products/lightbulb.html.twig',
            'products/soap.html.twig',
        ]);
        $menu = new AutoMenu($stubDir);
        $this->assertCount(4, $menu->getItems());
    }

    private function stubPageDirectory(array $files)
    {
        $dir = new FakePageDirectory('/tmp/pages');
        $dir->filepaths = $files;
        return $dir;
    }
}
