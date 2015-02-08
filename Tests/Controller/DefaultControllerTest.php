<?php

namespace DanLyn\ElasticsearchExplorerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/elasticsearchexplorer/');

        $this->assertTrue($crawler->filter('html:contains("ElasticsearchExplorer")')->count() > 0);
    }

    public function testConfig()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/elasticsearchexplorer/config/');

        $this->assertTrue($crawler->filter('html:contains("Host")')->count() > 0);
    }
}
