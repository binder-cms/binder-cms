<?php

namespace Tests\Binder\PageBundle\Functional;


use Symfony\Component\HttpFoundation\Response;
use Tests\Binder\FunctionalTestCase;

class MenuTest extends FunctionalTestCase
{
    public function testManualMenu()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertStatus(Response::HTTP_OK, $client->getResponse());
        echo $client->getResponse()->getContent();

        $this->assertCount(1, $crawler->filter('header nav'));
        $this->assertCount(1, $crawler->filter('header nav > ul'));
        $this->assertCount(2, $crawler->filter('header nav > ul > li'));
    }
}
