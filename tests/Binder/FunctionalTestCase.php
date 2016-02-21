<?php

namespace Tests\Binder;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Base class for full integration tests.
 */
abstract class FunctionalTestCase extends WebTestCase
{
    protected function assertStatus($statusCode, Response $response)
    {
        $actual = $response->getStatusCode();
        $msg = "Expected status $statusCode; got $actual";
        if ($actual === 500) {
            $msg .= "\n" . $response->getContent();
        }
        $this->assertEquals($statusCode, $actual, $msg);
    }

}
