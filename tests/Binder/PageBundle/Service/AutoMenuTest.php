<?php

namespace Tests\Binder\PageBundle\Service;

use Binder\PageBundle\Model\MenuItem;
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

    /**
     * @dataProvider templateToPathProvider
     */
    public function testGetItems_itemHasCorrectUrlPath($templateName, $expectedPath)
    {
        $stubDir = $this->stubPageDirectory([$templateName]);
        $menu = new AutoMenu($stubDir);

        /** @var $menuItem MenuItem */
        $menuItem = $menu->getItems()[0];

        $this->assertSame($expectedPath, $menuItem->getUrl());
    }

    public function templateToPathProvider()
    {
        return [
            ['index.html.twig', 'index.html'],
            ['products/lightbulb.html.twig', 'products/lightbulb.html'],
            [':pages:contact.html.twig', 'contact.html'],

        ];
    }

    /**
     * @dataProvider templateToLabelProvider
     */
    public function testGetItems_itemHasCorrectLabel($templateName, $expectedLabel)
    {
        $stubDir = $this->stubPageDirectory([$templateName]);
        $menu = new AutoMenu($stubDir);

        /** @var $menuItem MenuItem */
        $menuItem = $menu->getItems()[0];

        $this->assertSame($expectedLabel, $menuItem->getLabel());
    }

    public function templateToLabelProvider()
    {
        return [
            ['index.html.twig', 'Index'],
            ['about_us.html.twig', 'About us'],
            ['products/lightbulb.html.twig', 'Lightbulb'],
        ];
    }
}
