<?php

namespace Tests\Binder\PageBundle\Functional;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Tests\Binder\FunctionalTestCase;

class PageTest extends FunctionalTestCase
{
    /**
     * The index page works.
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertStatus(Response::HTTP_OK, $client->getResponse());

        $this->checkTemplate($crawler);

        $main = $crawler->filter('main')->text();
        $this->assertContains('This is the main content of the index page.', $main);
    }

    /**
     * The shared page template is correct.
     */
    private function checkTemplate(Crawler $crawler)
    {
        $h1 = $crawler->filter('header h1')->text();
        $this->assertEquals('Welcome to my wonderful site', $h1);

        $footer = $crawler->filter('footer')->text();
        $this->assertContains('This is the footer.', $footer);
    }

    /**
     * A top-level page other than the index path works.
     */
    public function testTopLevelPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about-us/');
        $this->assertStatus(Response::HTTP_OK, $client->getResponse());

        $this->checkTemplate($crawler);

        $main = $crawler->filter('main')->text();
        $this->assertContains('This is the about us page. We are great!', $main);
    }

    /**
     * A page with a longer path works.
     */
    public function testDeeperPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products/necklace');
        $this->assertStatus(Response::HTTP_OK, $client->getResponse());

        $this->checkTemplate($crawler);

        $main = $crawler->filter('main h2')->text();
        $this->assertContains('A nice necklace', $main);

        $p = $crawler->filter('main p')->text();
        $this->assertContains('gold and stuff', $p);
    }

    /**
     * An invalid path gives a 404 status code.
     */
    public function testNonExistentPage()
    {
        $client = static::createClient();
        $client->request('GET', '/no/such/page/exists');
        $this->assertStatus(Response::HTTP_NOT_FOUND, $client->getResponse());
    }

}
