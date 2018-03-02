<?php

namespace Tests\Binder\PageBundle\Service;

use Binder\PageBundle\Service\PageDirectory;
use Binder\PageBundle\Service\TemplateLocator;
use Symfony\Component\Templating\EngineInterface;
use Tests\Binder\UnitTestCase;

class TemplateLocatorTest extends UnitTestCase
{
    public function testTemplateExists_withInvalidPath_returnsFalse()
    {
        $pathExists = false;
        $templating = $this->fakeTemplating($pathExists);
        $directory = new FakePageDirectory('/tmp/pages');
        $locator = $this->makeLocator($templating, $directory);

        $result = $locator->templateExists('some/path.html');

        $this->assertFalse($result);
    }

    public function testTemplateExists_withValidPath_returnsTrue()
    {
        $pathExists = true;
        $templating = $this->fakeTemplating($pathExists);
        $directory = new FakePageDirectory('/tmp/pages');
        $locator = $this->makeLocator($templating, $directory);

        $result = $locator->templateExists('some/path.html');

        $this->assertTrue($result);
    }

    public function testPathToTemplate_withInvalidPath_throwsException()
    {
        $pathExists = false;
        $templating = $this->fakeTemplating($pathExists);
        $directory = new FakePageDirectory('/tmp/pages');
        $locator = $this->makeLocator($templating, $directory);

        $this->expectException(\InvalidArgumentException::class);
        $locator->pathToTemplate('some/path.html');
    }

    private function fakeTemplating($pathExists)
    {
        $templating = $this->createMock(EngineInterface::class);
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

        $this->assertSame($template, 'pages/some/path.html.twig');
    }
}
