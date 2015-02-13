<?php

namespace DanLyn\ElasticsearchExplorerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testConfig()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/config/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
