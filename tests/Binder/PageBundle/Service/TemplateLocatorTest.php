<?php

namespace Tests\Binder\PageBundle\Service;

use Binder\PageBundle\Service\PageDirectory;
use Binder\PageBundle\Service\TemplateLocator;
use Symfony\Component\Templating\EngineInterface;
use Tests\Binder\UnitTestCase;

class TemplateLocatorTest extends UnitTestCase
{
    public function testPathToTemplate_withInvalidPath_returnsNull()
    {
        $pathExists = false;
        $templating = $this->fakeTemplating($pathExists);
        $directory = new FakePageDirectory('/tmp/pages');
        $locator = $this->makeLocator($templating, $directory);

        $template = $locator->pathToTemplate('some/path.html');

        $this->assertNull($template);
    }

    private function fakeTemplating($pathExists)
    {
        $templating = $this->getMock(EngineInterface::class);
        $templating->method('exists')
            ->willReturn($pathExists);
        return $templating;
    }

    private function makeLocator(EngineInterface $templating,
                                 PageDirectory $directory)
    {
        return new TemplateLocator($templating, $directory);
    }

    public function testPathToTemplate_withValidPath_returnsTemplate()
    {
        $pathExists = true;
        $templating = $this->fakeTemplating($pathExists);
        $directory = new FakePageDirectory('/tmp/pages');
        $locator = $this->makeLocator($templating, $directory);

        $template = $locator->pathToTemplate('some/path.html');

        $this->assertSame($template, ':pages:some/path.html.twig');
    }
}
