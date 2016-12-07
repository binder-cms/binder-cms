<?php

namespace Tests\Binder\PageBundle\Service;

use Binder\PageBundle\Service\UrlResolver;
use Tests\Binder\UnitTestCase;

class UrlResolverTest extends UnitTestCase
{
    /**
     * @dataProvider templateToPathProvider
     */
    public function testTemplateToPath($template, $expectedPath)
    {
        $pagepath = '/tmp/pages';
        $resolver = $this->makeResolver($pagepath);

        $actualPath = $resolver->templateToPath($template);

        $this->assertSame($expectedPath, $actualPath);
    }

    public function templateToPathProvider()
    {
        return [
            ['index.html.twig', 'index.html'],
            ['about_us.html.twig', 'about_us.html'],
            ['stuff/index.html.twig', 'stuff/index.html'],
            [':pages:index.html.twig', 'index.html'],
            [':pages:things/stuff/index.html.twig', 'things/stuff/index.html'],
        ];
    }

    /**
     * @param string $pagepath
     * @return UrlResolver
     */
    private function makeResolver($pagepath)
    {
        $directory = new FakePageDirectory($pagepath);
        return new UrlResolver($directory);
    }
}
