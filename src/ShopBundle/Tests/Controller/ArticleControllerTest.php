<?php

namespace ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testViewarticle()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/article');
    }

}
