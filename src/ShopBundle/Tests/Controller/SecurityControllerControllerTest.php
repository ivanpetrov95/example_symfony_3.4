<?php

namespace ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
    }

}
